<?php

namespace App\Filament\Admin\Resources\MasterThicknessExternals\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MasterThicknessExternalsTable
{
    protected const LAYERS = ['1V', '1M', '1M1V'];

    public static function configure(Table $table): Table
    {
        $layerColumns = collect(self::LAYERS)->map(function (string $layer) {
            return TextColumn::make("thickness_{$layer}")
                ->label($layer)
                ->getStateUsing(function ($record) use ($layer) {
                    $found = $record->thicknessExternals->firstWhere('layer', $layer);
                    return $found ? number_format($found->thickness, 2) . ' mm' : '-';
                })
                ->alignCenter();
        })->toArray();

        return $table
        ->deferLoading()
            ->query(
                \App\Models\MasterDiameter::query()
                    ->with(['thicknessExternals'])
                    ->whereHas('thicknessExternals')
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
                ...$layerColumns,
            ])
            ->filters([]);
    }
}
