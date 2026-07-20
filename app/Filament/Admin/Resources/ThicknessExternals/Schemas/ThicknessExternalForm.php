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
                Grid::make(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('external_code')
                            ->label('External Code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->live(onBlur: true)
                            ->extraInputAttributes(['class' => 'readonly-highlight-input']),

                        TextInput::make('thickness_actual')
                            ->label('Thickness Specs')
                            ->numeric()
                            ->required(),

                        TextInput::make('thickness_teori')
                            ->label('Thickness Teori')
                            ->readonly()
                            ->default(0.00)
                            ->placeholder('auto')
                            ->extraInputAttributes(['class' => 'readonly-highlight-input']),

                        TextInput::make('layers_formula')
                            ->label('Formula Layer')
                            ->readonly()
                            ->placeholder('automatically from the layer')
                            ->extraInputAttributes(['class' => 'readonly-highlight-input']),
                    ]),

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
