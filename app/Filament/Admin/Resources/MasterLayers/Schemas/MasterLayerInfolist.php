<?php

namespace App\Filament\Admin\Resources\MasterLayers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class MasterLayerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(4)
                            ->schema([

                                TextEntry::make('category')
                                    ->label('Category')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'hand_layup'       => 'info',
                                        'filament_winding' => 'success',
                                        default            => 'gray',
                                    })
                                    ->formatStateUsing(fn(string $state): string => match ($state) {
                                        'hand_layup'       => 'Hand Layup',
                                        'filament_winding' => 'Filament Winding',
                                        default            => $state,
                                    }),

                                TextEntry::make('operator')
                                    ->label('Operator')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        '<'       => 'info',
                                        'between' => 'warning',
                                        '>'       => 'success',
                                        default   => 'gray',
                                    }),

                                TextEntry::make('diameter1.diameter_mm')
                                    ->label('Diameter 1')
                                    ->suffix(' mm'),

                                TextEntry::make('diameter2.diameter_mm')
                                    ->label('Diameter 2')
                                    ->suffix(' mm')
                                    ->placeholder('-'),
                            ]),
                    ]),

                Section::make('Layer Matrix')
                    ->columnSpanFull()
                    ->schema([
                        ViewEntry::make('layer_matrix')
                            ->label('')
                            ->view('filament.admin.infolists.master-layer-table'),
                    ]),
            ]);
    }
}
