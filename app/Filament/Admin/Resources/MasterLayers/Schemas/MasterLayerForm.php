<?php

namespace App\Filament\Admin\Resources\MasterLayers\Schemas;

use App\Models\MasterDiameter;
use App\Models\MasterMaterialType;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class MasterLayerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Configuration')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('category')
                                    ->options([
                                        'hand_layup'       => 'Hand Layup',
                                        'filament_winding' => 'Filament Winding',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->live(),

                                Select::make('operator')
                                    ->options(['<' => '<', 'between' => 'between', '>' => '>'])
                                    ->required()
                                    ->live()
                                    ->native(false),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('diameter_id_1')
                                    ->label('Diameter 1')
                                    ->options(MasterDiameter::orderBy('diameter_mm', 'asc')->pluck('diameter_mm', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->disabled(fn(Get $get) => blank($get('operator'))),

                                Select::make('diameter_id_2')
                                    ->label('Diameter 2')
                                    ->options(MasterDiameter::orderBy('diameter_mm', 'asc')->pluck('diameter_mm', 'id'))
                                    ->searchable()
                                    ->visible(fn(Get $get) => $get('operator') === 'between')
                                    ->required(fn(Get $get) => $get('operator') === 'between')
                                    ->disabled(fn(Get $get) => blank($get('operator'))),
                            ]),
                    ]),

                Section::make('Thickness & Stages Configuration')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('thicknesses')
                            ->label('Thickness List')
                            ->addActionLabel('Add Thickness')
                            ->collapsible()
                            ->collapsed(false)
                            ->itemLabel(
                                fn(array $state): ?string =>
                                isset($state['thickness']) && $state['thickness'] !== ''
                                    ? 'Thickness: ' . $state['thickness'] . ' mm'
                                    : 'New Thickness'
                            )
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('thickness')
                                            ->label('Thickness (mm)')
                                            ->numeric()
                                            ->required()
                                            ->live(onBlur: true)
                                    ]),

                                Repeater::make('stages')
                                    ->label('Stage List')
                                    ->addActionLabel('Add New Stage')
                                    ->collapsible()
                                    ->collapsed(false)
                                    ->itemLabel(
                                        fn(array $state, $key, Repeater $component): ?string =>
                                        "Stage " . (array_search($key, array_keys($component->getState())) + 1)
                                    )
                                    ->schema([
                                        Repeater::make('steps')
                                            ->label('Steps List')
                                            ->schema([
                                                Grid::make(3)
                                                    ->schema([
                                                        TextInput::make('layer_value')
                                                            ->label('Layer')
                                                            ->readonly()
                                                            ->required()
                                                            ->dehydrated(),

                                                        Select::make('material_type_id')
                                                            ->label('Material Type')
                                                            ->options(MasterMaterialType::all()->pluck('type_name', 'id'))
                                                            ->searchable()
                                                            ->native(false)
                                                            ->live()
                                                            ->afterStateUpdated(function ($state, callable $set) {
                                                                if ($state) {
                                                                    $material = MasterMaterialType::find($state);
                                                                    $set('type_code', $material?->type_code);
                                                                } else {
                                                                    $set('type_code', null);
                                                                }
                                                            }),

                                                        TextInput::make('type_code')
                                                            ->label('Type Code')
                                                            ->readonly()
                                                            ->placeholder('Auto')
                                                            ->dehydrated(false),

                                                        TextInput::make('step_number')
                                                            ->hidden()
                                                            ->dehydrated(),
                                                    ]),
                                            ])
                                            ->addable(false)
                                            ->deletable(false)
                                            ->reorderable(false)
                                            ->default(function () {
                                                $steps = [];
                                                for ($i = 1; $i <= 7; $i++) {
                                                    $steps[] = [
                                                        'step_number'      => $i,
                                                        'layer_value'      => "Layer $i",
                                                        'material_type_id' => null,
                                                        'type_code'        => null,
                                                    ];
                                                }
                                                return $steps;
                                            }),
                                    ])
                                    ->compact(),
                            ])
                            ->compact(),
                    ]),
            ]);
    }
}
