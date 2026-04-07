<?php

namespace App\Filament\Admin\Resources\MasterMaterials\Tables;

use Filament\Tables\Columns\TextColumn;
use App\Filament\Admin\Resources\MasterMaterials\MasterMaterialResource;
use Filament\Tables\Table;

class MasterMaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->deferLoading()
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('material_id')
                    ->searchable(),
                TextColumn::make('material_name')
                    ->searchable(),
                TextColumn::make('trade_name')
                    ->searchable(),
                TextColumn::make('international_name')
                    ->searchable(),
                TextColumn::make('id_material_type')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('id_measurement')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('unit_measurement')
                    ->searchable(),
                TextColumn::make('conversion_value')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('id_packing')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('unit_packing')
                    ->searchable(),
                TextColumn::make('min_stock_day')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max_stock_day')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('monthly_requirement')
                    ->numeric()
                    ->sortable(),
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
                // TrashedFilter::make(),
            ])
            ->recordActions([
                ...MasterMaterialResource::getRecordActions(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                //     ForceDeleteBulkAction::make(),
                //     RestoreBulkAction::make(),
                // ]),
            ]);
    }
}
