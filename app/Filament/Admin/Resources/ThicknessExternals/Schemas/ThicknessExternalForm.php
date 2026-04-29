<?php

namespace App\Filament\Admin\Resources\ThicknessExternals\Schemas;

use App\Models\MasterMaterialType;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;

class ThicknessExternalForm
{
    protected static function updateFormula(Get $get, Set $set, string $path = 'layers_formula'): void
    {
        $layers = $get('layers') ?? $get('../../layers') ?? [];

        $formula = collect($layers)
            ->map(function ($layer) {
                $code = $layer['material_code'] ?? '';
                return $code !== '' ? substr($code, 0, 1) : null;
            })
            ->filter()
            ->implode('-');

        $set($path, strtoupper($formula));
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('external_code')
                    ->label('External Code')
                    ->readonly()
                    ->placeholder('Auto generated saat simpan')
                    ->columnSpanFull()
                    ->extraInputAttributes(['class' => 'font-bold bg-gray-50 text-primary-600'])
                    ->visibleOn('edit'),

                Grid::make(3)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('material_type_id')
                            ->label('Resin Type')
                            ->options(MasterMaterialType::where('category_types', 1)->pluck('type_name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                if (!$state) {
                                    $set('material_type_code', null);
                                    $set('material_type_name', null);
                                    return;
                                }
                                $material = MasterMaterialType::find($state);
                                if ($material) {
                                    $set('material_type_name', $material->type_name);
                                    $set('material_type_code', $material->type_code);
                                }
                            }),

                        Hidden::make('material_type_code'),
                        Hidden::make('material_type_name'),

                        TextInput::make('thickness_actual')
                            ->label('Thickness Specs')
                            ->numeric()
                            ->required(),

                        TextInput::make('thickness_teori')
                            ->label('Thickness Teori')
                            ->readonly()
                            ->default(0.00)
                            ->placeholder('auto')
                            ->extraInputAttributes(['class' => 'bg-gray-100']),
                    ]),

                TextInput::make('layers_formula')
                    ->label('Formula Layer')
                    ->readonly()
                    ->placeholder('automatically from the layer')
                    ->columnSpanFull()
                    ->extraInputAttributes(['class' => 'font-bold bg-gray-50']),

                Repeater::make('layers')
                    ->relationship('layers')
                    ->schema([
                        TextInput::make('layer_no')
                            ->label('Layer No')
                            ->readonly()
                            ->default(fn(Get $get) => count($get('../../layers') ?? [])),

                        Select::make('material_type_id')
                            ->label('Material')
                            ->options(MasterMaterialType::where('category_types', 2)->pluck('type_name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                if (!$state) {
                                    $set('material_code', null);
                                    $set('engineering_value', 0);
                                } else {
                                    $material = MasterMaterialType::find($state);
                                    if ($material) {
                                        $set('material_code', $material->type_code);

                                        // Ambil C008 untuk External (bukan C006)
                                        $c008Value = $material->engineeringDetails()
                                            ->whereHas('engineering', fn($q) => $q->where('engineering_code', 'C008'))
                                            ->first()?->engineering_value ?? 0;

                                        $set('engineering_value', $c008Value);
                                    }
                                }

                                $total = collect($get('../../layers') ?? [])->sum('engineering_value');
                                $set('../../thickness_teori', number_format((float)$total, 2, '.', ''));
                                static::updateFormula($get, $set, '../../layers_formula');
                            }),

                        TextInput::make('material_code')
                            ->label('Code')
                            ->readonly(),

                        TextInput::make('engineering_value')
                            ->label('Thickness')
                            ->numeric()
                            ->readonly()
                            ->required(),
                    ])
                    ->columns(4)
                    ->columnSpanFull()
                    ->addActionLabel('Tambah Layer Baru')
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $total = collect($get('layers') ?? [])->sum('engineering_value');
                        $set('thickness_teori', number_format((float)$total, 2, '.', ''));
                        static::updateFormula($get, $set, 'layers_formula');
                    })
                    ->collapsible(),
            ]);
    }
}