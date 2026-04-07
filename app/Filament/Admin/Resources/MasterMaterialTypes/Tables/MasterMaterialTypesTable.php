<?php

namespace App\Filament\Admin\Resources\MasterMaterialTypes\Tables;

use App\Filament\Admin\Resources\MasterMaterialTypes\MasterMaterialTypeResource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MasterMaterialTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->deferLoading()
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('category_types')
                    ->label('Category')
                    ->formatStateUsing(fn(int $state): string => match ($state) {
                        1 => 'Resin',
                        2 => 'Non Resin',
                        default => 'Unknown',
                    })
                    ->badge() 
                    ->color(fn(int $state): string => match ($state) {
                        1 => 'success',
                        2 => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('type_code')
                    ->searchable(),
                TextColumn::make('type_name')
                    ->searchable()
            ])
            
            ->recordActions([
                ...MasterMaterialTypeResource::getRecordActions(),
            ]);
    }
}
