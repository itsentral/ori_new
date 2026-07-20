<?php

namespace App\Filament\Admin\Resources\ThicknessExternals\Tables;

use App\Filament\Admin\Resources\ThicknessExternals\ThicknessExternalResource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ThicknessExternalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),

                TextColumn::make('external_code')
                    ->label('External Code')
                    ->copyable()
                    ->searchable(),

                TextColumn::make('layers_formula')
                    ->label('Formula')
                    ->searchable(),

                TextColumn::make('thickness_actual')
                    ->label('Specs. Thick')
                    ->suffix(' mm')
                    ->sortable(),

                TextColumn::make('thickness_teori')
                    ->label('Theo. Thick')
                    ->suffix(' mm')
                    ->state(fn($record) => number_format($record->thickness_teori, 2))
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ...ThicknessExternalResource::getRecordActions(),
            ]);
    }
}
