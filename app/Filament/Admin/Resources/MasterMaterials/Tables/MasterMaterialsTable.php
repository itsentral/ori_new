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
                    ->searchable()
                    ->default('-'),
                TextColumn::make('materialType.type_name')
                    ->label('Material Type')
                    ->searchable()
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
            ->recordActions([
                ...MasterMaterialResource::getRecordActions(),
            ]);
    }
}
