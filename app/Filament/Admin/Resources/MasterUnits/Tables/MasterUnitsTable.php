<?php

namespace App\Filament\Admin\Resources\MasterUnits\Tables;

use App\Filament\Admin\Resources\MasterUnits\MasterUnitResource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MasterUnitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),

                TextColumn::make('pieces_code')
                    ->label('Code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('pieces_name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('remark')
                    ->label('Remark')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->recordActions([
                ...MasterUnitResource::getRecordActions(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
