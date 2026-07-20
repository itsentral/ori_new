<?php

namespace App\Filament\Admin\Resources\ThicknessCalculations\Schemas;

use App\Models\MasterApplication;
use App\Models\MasterPressureNominal;
use App\Models\ThicknessExternal;
use App\Models\ThicknessLiner;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Hidden;

class ThicknessCalculationForm
{
    protected static function updateBrandName(\Filament\Schemas\Components\Utilities\Get $get, \Filament\Schemas\Components\Utilities\Set $set): void
    {
        $linerResinId = $get('liner_resin_id');
        $linerId = $get('liner_id');
        $pnId = $get('pressure_nominal_id');
        $techId = $get('technology_id');

        $parts = [];

        if ($linerResinId) {
            $parts[] = \App\Models\MasterMaterialType::find($linerResinId)?->type_code ?? '';
        }
        if ($linerId) {
            $parts[] = \App\Models\ThicknessLiner::find($linerId)?->liner_code ?? '';
        }
        if ($pnId) {
            $parts[] = \App\Models\MasterPressureNominal::find($pnId)?->pn_name ?? '';
        }
        if ($techId) {
            $parts[] = \App\Models\MasterTechnology::find($techId)?->technology_option ?? '';
        }

        $brandName = implode(' - ', array_filter($parts));
        $set('brand_name', $brandName);
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Informasi Umum')
                ->extraAttributes(['class' => 'thickness-form-section'])
                ->columns(2)
                ->schema([
                    TextInput::make('brand_name')
                        ->label('Brand Name')
                        ->readonly()
                        ->placeholder('Auto generated')
                        ->columnSpan(2)
                        ->extraInputAttributes(['class' => 'readonly-highlight-input']),
                ]),

            Section::make('Liner')
                ->extraAttributes(['class' => 'thickness-form-section'])
                ->columns(2)
                ->schema([
                    Select::make('liner_id')
                        ->label('Pilih Liner')
                        ->required()
                        ->options(
                            ThicknessLiner::all()->mapWithKeys(function ($l) {

                                $corrosionMap = [
                                    1 => 'Low',
                                    2 => 'Medium',
                                    3 => 'High',
                                ];

                                $tempratureMap = [
                                    1 => 'Low',
                                    2 => 'Medium',
                                    3 => 'High',
                                ];

                                $corrosion = $corrosionMap[$l->corrosion] ?? '-';
                                $temprature = $tempratureMap[$l->temprature] ?? '-';

                                return [
                                    $l->id => "{$corrosion} Corrosion, {$temprature} temprature - {$l->material_type_name} - {$l->thickness_teori} mm "
                                ];
                            })
                        )
                        ->reactive()
                        ->afterStateUpdated(function ($state, $set, $get) {
                            if ($state) {
                                $liner = ThicknessLiner::find($state);
                                $set('liner_code_snapshot', $liner?->liner_code);
                                $set('liner_material_type_snapshot', $liner?->material_type_name);
                                $set('liner_thickness_snapshot', $liner?->thickness_teori);
                            } else {
                                $set('liner_code_snapshot', null);
                                $set('liner_material_type_snapshot', null);
                                $set('liner_thickness_snapshot', null);
                            }
                            self::updateBrandName($get, $set);
                        })
                        ->columnSpan(2),

                    Hidden::make('liner_code_snapshot'),
                    Hidden::make('liner_material_type_snapshot'),
                    Hidden::make('liner_thickness_snapshot'),
                ]),

            Section::make('Struktur')
                ->extraAttributes(['class' => 'thickness-form-section'])
                ->columns(2)
                ->schema([
                    Select::make('temperature')
                        ->label('temprature')
                        ->required()
                        ->options([
                            '65' => '65°C',
                            '80' => '>80°C',
                        ]),

                    Select::make('pressure_nominal_id')
                        ->label('Pressure Nominal')
                        ->required()
                        ->options(
                            MasterPressureNominal::orderByRaw("CAST(SUBSTRING(pn_name, 3) AS UNSIGNED) ASC")
                                ->get()
                                ->mapWithKeys(
                                    fn($pn) => [$pn->id => $pn->pn_name]
                                )
                        )
                        ->reactive()
                        ->afterStateUpdated(function ($state, $set, $get) {
                            if ($state) {
                                $pn = MasterPressureNominal::find($state);
                                $set('pn_name_snapshot', $pn?->pn_name);
                                $set('pn_value_snapshot', $pn?->pn_value);
                            } else {
                                $set('pn_name_snapshot', null);
                                $set('pn_value_snapshot', null);
                            }
                            self::updateBrandName($get, $set);
                        }),

                    Select::make('stiffness_snapshot')
                        ->label('Stiffness (SN)')
                        ->required()
                        ->options([
                            '1250'  => 'SN1250',
                            '2500'  => 'SN2500',
                            '5000'  => 'SN5000',
                            '10000' => 'SN10000',
                        ]),

                    Select::make('vacuum_type')
                        ->label('Tipe Vacuum')
                        ->required()
                        ->options([
                            'intermitten' => 'Intermitten',
                            'continues'   => 'Continues',
                        ])
                        ->reactive()
                        ->afterStateUpdated(function ($state, $set) {
                            // Reset vacuum_load saat vacuum_type berubah
                            if (!$state) {
                                $set('vacuum_load_snapshot', null);
                            }
                        }),

                    Select::make('vacuum_load_snapshot')
                        ->label('Parameter Vacuum')
                        ->required()
                        ->visible(fn($get) => filled($get('vacuum_type')))
                        ->options(function () {
                            return \App\Models\ThicknessVacuum::select('vacuum_load')
                                ->distinct()
                                ->orderBy('vacuum_load')
                                ->get()
                                ->mapWithKeys(fn($row) => [
                                    number_format((float) $row->vacuum_load, 2) => number_format((float) $row->vacuum_load, 2)
                                ]);
                        })
                        ->reactive()
                        ->columnSpan(2),

                    Hidden::make('pn_name_snapshot'),
                    Hidden::make('pn_value_snapshot'),
                ]),

            // ThicknessCalculationForm.php — Section External & Top Coat

            Section::make('External & Top Coat')
                ->extraAttributes(['class' => 'thickness-form-section'])
                ->columns(2)
                ->schema([
                    Toggle::make('use_external')
                        ->label('Pakai External?')
                        ->reactive(),

                    Toggle::make('use_top_coat')
                        ->label('Pakai Top Coat?')
                        ->live(),

                    Select::make('external_id')
                        ->label('Pilih External')
                        ->visible(fn($get) => $get('use_external'))
                        ->options(
                            ThicknessExternal::all()->mapWithKeys(fn($e) => [
                                $e->id => "{$e->external_code} — {$e->material_type_name} ({$e->layers_formula}) {$e->thickness_teori} mm"
                            ])
                        )
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state, Set $set) {
                            if ($state) {
                                $ext = ThicknessExternal::find($state);
                                $set('external_code_snapshot', $ext?->external_code);
                                $set('external_thickness_snapshot', $ext?->thickness_teori);
                            } else {
                                $set('external_code_snapshot', null);
                                $set('external_thickness_snapshot', null);
                            }
                        })
                        ->columnSpan(2),

                    Hidden::make('external_code_snapshot'),
                    Hidden::make('external_thickness_snapshot'),
                ]),

            Section::make('Layer, Technology & Application')
                ->extraAttributes(['class' => 'thickness-form-section'])
                ->columns(2)
                ->schema([
                    Select::make('layer_category')
                        ->label('Kategori Layer')
                        ->required()
                        ->options([
                            'filament_winding' => 'Filament Winding (FW)',
                            'hand_layup'       => 'Hand Layup (HLU)',
                        ]),

                    Select::make('technology_id')
                        ->label('Pilih Technology')
                        ->options(fn() => \App\Models\MasterTechnology::pluck('technology_option', 'id'))
                        ->searchable()
                        ->preload()
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn($get, $set) => self::updateBrandName($get, $set)),

                    Select::make('application_ids')
                        ->label('Application')
                        ->multiple()
                        ->options(function () {
                            return MasterApplication::pluck('application_name', 'id');
                        })
                        ->preload()
                        ->columnSpan(2),
                ]),

            Section::make('Resin Option')
                ->extraAttributes(['class' => 'thickness-form-section'])
                ->columns(2)
                ->schema([
                    Select::make('liner_resin_id')
                        ->label('Liner Resin Type')
                        ->options(fn() => \App\Models\MasterMaterialType::where('category_types', 1)->pluck('type_name', 'id'))
                        ->searchable()
                        ->preload()
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn($get, $set) => self::updateBrandName($get, $set)),

                    Select::make('structure_resin_id')
                        ->label('Structure Resin Type')
                        ->options(fn() => \App\Models\MasterMaterialType::where('category_types', 1)->pluck('type_name', 'id'))
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('external_resin_id')
                        ->label('External Resin Type')
                        ->options(fn() => \App\Models\MasterMaterialType::where('category_types', 1)->pluck('type_name', 'id'))
                        ->visible(fn($get) => $get('use_external'))
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('top_coat_resin_id')
                        ->label('Top Coat Resin Type')
                        ->options(fn() => \App\Models\MasterMaterialType::where('category_types', 1)->pluck('type_name', 'id'))
                        ->visible(fn($get) => $get('use_top_coat'))
                        ->searchable()
                        ->preload()
                        ->required(),
                ]),

        ]);
    }
}
