<?php

namespace App\Filament\Admin\Resources\MasterApplications\Tables;

use App\Filament\Admin\Resources\MasterApplications\MasterApplicationResource;
use Filament\Tables;
use Filament\Tables\Table;

class MasterApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('application_name')
                    ->label('Application Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('application_code')
                    ->label('Application Code')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->default('-')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Created at')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                ...MasterApplicationResource::getRecordActions(),
            ]);
    }
}
