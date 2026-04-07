<?php

namespace App\Filament\Admin\Resources\MasterTopCoats\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MasterTopCoatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->query(
                \App\Models\MasterDiameter::query()
                    ->with(['topCoat'])
                    ->whereHas('topCoat')
                    ->orderBy('diameter_mm')
            )
            ->columns([
                TextColumn::make('no')
                    ->rowIndex()
                    ->width('50px'),
                TextColumn::make('diameter_inch')
                    ->label('Diameter (inch)')
                    ->sortable(),
                TextColumn::make('diameter_mm')
                    ->label('Diameter (mm)')
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('topCoat.thickness')
                    ->label('Thickness (mm)')
                    ->numeric(2)
                    ->alignCenter(),
            ])
            ->filters([])
            ->recordActions([]);
    }
}
