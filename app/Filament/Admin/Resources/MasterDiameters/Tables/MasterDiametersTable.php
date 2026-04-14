<?php

namespace App\Filament\Admin\Resources\MasterDiameters\Tables;

use App\Filament\Admin\Resources\MasterDiameters\MasterDiameterResource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MasterDiametersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('diameter_mm')
                    ->searchable()

                    ->sortable(query: function ($query, $direction) {
                        return $query->orderByRaw("CAST(diameter_mm AS UNSIGNED) {$direction}");
                    }),
                TextColumn::make('diameter_inch')
                    ->searchable()
                    ->sortable(),
            ])

            ->defaultSort(
                'diameter_mm',
                'asc',
                fn($query) =>
                $query->orderByRaw('diameter_mm + 0 ASC')
            )
            ->filters([
                //
            ])
            ->recordActions([
                ...MasterDiameterResource::getRecordActions(),
            ]);
    }
}
