<?php

namespace App\Filament\Admin\Resources\MasterLayers\Tables;

use App\Filament\Admin\Resources\MasterLayers\MasterLayerResource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MasterLayersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('layer_code')
                    ->label('Layer Code')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('operator')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        '<' => 'info',
                        'between' => 'warning',
                        '>' => 'success',
                        default => 'gray',
                    })
                    ->searchable(),

                TextColumn::make('diameter1.diameter_mm')
                    ->label('Diameter 1')
                    ->suffix(' mm')
                    ->sortable(),

                TextColumn::make('diameter2.diameter_mm')
                    ->label('Diameter 2')
                    ->suffix(' mm')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('thicknesses_count')
                    ->label('Thickness Count')
                    ->counts('thicknesses')
                    ->badge()
                    ->color('info')
                    ->suffix(' Thickness'),

                TextColumn::make('thicknesses.thickness')
                    ->label('Thicknesses (mm)')
                    ->listWithLineBreaks()
                    ->bulleted()
                    ->limitList(3)
                    ->expandableLimitedList(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                ...MasterLayerResource::getRecordActions(),
            ]);
    }
}