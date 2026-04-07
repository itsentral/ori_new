<?php

namespace App\Filament\Admin\Resources\MasterStandardEngineerings\Tables;

use App\Filament\Admin\Resources\MasterStandardEngineerings\MasterStandardEngineeringResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MasterStandardEngineeringsTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->deferLoading()
            ->columns([
                TextColumn::make('engineering_name')
                    ->searchable(),
                TextColumn::make('engineering_unit')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ...MasterStandardEngineeringResource::getRecordActions(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
