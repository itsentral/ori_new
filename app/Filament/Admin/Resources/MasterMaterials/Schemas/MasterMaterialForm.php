<?php

namespace App\Filament\Admin\Resources\MasterMaterials\Schemas;

use App\Models\MasterMaterialType;
use App\Models\MasterPiece;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class MasterMaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Material Information')
                ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('material_id')
                                    ->label('Material ID')
                                    ->inlineLabel()
                                    ->required()
                                    ->unique(ignoreRecord: true),

                                TextInput::make('material_name')
                                    ->label('Material Name')
                                    ->inlineLabel()
                                    ->required(),

                                TextInput::make('trade_name')
                                    ->label('Trade Name')
                                    ->inlineLabel(),

                                TextInput::make('international_name')
                                    ->label('Int. Name')
                                    ->inlineLabel(),

                                Select::make('id_material_type')
                                    ->label('Material Type')
                                    ->inlineLabel()
                                    ->options(MasterMaterialType::all()->pluck('type_name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                // Select Measurement
                                Select::make('id_measurement')
                                    ->label('Measurement')
                                    ->inlineLabel()
                                    ->options(MasterPiece::where('category_pieces', 1)->pluck('pieces_name', 'id'))
                                    ->searchable()
                                    ->live() // Memastikan perubahan langsung terdeteksi
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        $piece = MasterPiece::find($state);
                                        $set('unit_measurement', $piece?->pieces_code);
                                    })
                                    ->required(),

                                // Select Packing
                                Select::make('id_packing')
                                    ->label('Packing')
                                    ->inlineLabel()
                                    ->options(MasterPiece::where('category_pieces', 2)->pluck('pieces_name', 'id'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        $piece = MasterPiece::find($state);
                                        $set('unit_packing', $piece?->pieces_code);
                                    })
                                    ->required(),

                                TextInput::make('conversion_value')
                                    ->label('Conversion')
                                    ->inlineLabel()
                                    ->numeric(),

                                TextInput::make('min_stock_day')
                                    ->label('Min Stock')
                                    ->inlineLabel()
                                    ->numeric()
                                    ->default(0),

                                TextInput::make('max_stock_day')
                                    ->label('Max Stock')
                                    ->inlineLabel()
                                    ->numeric()
                                    ->default(0),

                                TextInput::make('monthly_requirement')
                                    ->label('Monthly Req.')
                                    ->inlineLabel()
                                    ->numeric()
                                    ->default(0.0),

                        Textarea::make('description')
                            ->label('Description')
                            ->inlineLabel(),
                                Hidden::make('unit_measurement'),
                                Hidden::make('unit_packing'),
                            ]),

                    ])
            ]);
    }
}