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
                TextColumn::make('diameter_inch')
                    ->searchable(),
                TextColumn::make('diameter_mm')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ...MasterDiameterResource::getRecordActions(),
            ]);
    }
}
