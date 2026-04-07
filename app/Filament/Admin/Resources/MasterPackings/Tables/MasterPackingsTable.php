<?php

namespace App\Filament\Admin\Resources\MasterPackings\Tables;

use App\Filament\Admin\Resources\MasterPackings\MasterPackingResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class MasterPackingsTable
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
            ->filters([
                TrashedFilter::make(),
            ])
            
            ->recordActions([
                ...MasterPackingResource::getRecordActions(),
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
