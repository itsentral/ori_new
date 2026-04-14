<?php

namespace App\Filament\Admin\Resources\MasterMaterialTypes\Schemas;

use App\Models\MasterStandardEngineering;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class MasterMaterialTypeForm
{
    private static function isCosting(): bool
    {
        $user = auth()->user();
        return $user->hasRole('costing') && ! $user->hasRole('super_admin');
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('category_types')
                            ->label('Category')
                            ->options([
                                1 => 'Resin',
                                2 => 'Non Resin',
                            ])
                            ->required()
                            ->native(false)
                            // costing tidak bisa edit field utama
                            ->disabled(fn() => self::isCosting()),

                        TextInput::make('type_code')
                            ->label('Type Code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->disabled(fn() => self::isCosting()),

                        TextInput::make('type_name')
                            ->label('Type Name')
                            ->required()
                            ->disabled(fn() => self::isCosting()),
                    ]),

                Textarea::make('remark')
                    ->columnSpanFull()
                    ->disabled(fn() => self::isCosting()),

                // --- Price Reference: hanya visible untuk costing ---
                Section::make('Price Reference')
                    ->description('Diisi oleh tim Costing')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('price_kurs')
                                    ->label('Kurs (IDR/USD)')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0)
                                    ->required(fn() => self::isCosting())
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        // reset USD & IDR jika kurs diubah untuk menghindari inkonsistensi
                                        $set('price_usd', null);
                                        $set('price_idr', null);
                                    }),

                                TextInput::make('price_usd')
                                    ->label('Price (USD)')
                                    ->numeric()
                                    ->prefix('$')
                                    ->minValue(0)
                                    ->disabled(fn(callable $get) => blank($get('price_kurs')))
                                    ->dehydrated(true)
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $kurs = (float) $get('price_kurs');
                                        if ($kurs > 0 && is_numeric($state)) {
                                            $set('price_idr', round((float) $state * $kurs, 2));
                                        }
                                    }),

                                TextInput::make('price_idr')
                                    ->label('Price (IDR)')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0)
                                    ->disabled(fn(callable $get) => blank($get('price_kurs')))
                                    ->dehydrated(true)
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $kurs = (float) $get('price_kurs');
                                        if ($kurs > 0 && is_numeric($state)) {
                                            $set('price_usd', round((float) $state / $kurs, 2));
                                        }
                                    }),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->visible(fn() => self::isCosting() || auth()->user()->hasRole('super_admin')),

                // --- Engineering Details: visible semua, tapi costing tidak bisa edit ---
                Repeater::make('engineeringDetails')
                    ->relationship()
                    ->schema([
                        Select::make('engineering_id')
                            ->label('Standard Engineering')
                            ->options(
                                MasterStandardEngineering::all()
                                    ->mapWithKeys(fn($item) => [
                                        $item->id => "{$item->engineering_name} ({$item->engineering_unit})"
                                    ])
                            )
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->disabled(fn() => self::isCosting()),

                        TextInput::make('engineering_value')
                            ->label('Value')
                            ->required()
                            ->disabled(fn() => self::isCosting()),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->addActionLabel('Tambah Row Engineering')
                    ->collapsible()
                    ->addable(fn() => ! self::isCosting())
                    ->deletable(fn() => ! self::isCosting()),
            ]);
    }
}
