<?php

namespace App\Filament\Admin\Resources\ThicknessLiners\Tables;

use App\Filament\Admin\Resources\ThicknessLiners\ThicknessLinerResource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ThicknessLinersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('liner_code')
                    ->label('Liner Code')
                    ->copyable()
                    ->searchable(),

                TextColumn::make('aplikasi')
                    ->label('Aplikasi')
                    ->getStateUsing(function ($record) {
                        $cor = match ($record->corrosion) {
                            1 => 'Low Corrosion',
                            2 => 'Medium Corrosion',
                            3 => 'High Corrosion',
                            default => '-',
                        };
                        $temp = match ($record->temprature) {
                            1 => 'Low Temp',
                            2 => 'Medium Temp',
                            3 => 'High Temp',
                            default => '-',
                        };
                        return "{$cor}, {$temp}";
                    })
                    ->description(fn($record) => $record->layers_formula)
                    ->searchable(['liner_code', 'liner_name']),

                TextColumn::make('resinType.type_name')
                    ->label('Resin Type')
                    ->sortable(),

                TextColumn::make('thickness_actual')
                    ->label('Act. Thick')
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
                ...ThicknessLinerResource::getRecordActions(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
