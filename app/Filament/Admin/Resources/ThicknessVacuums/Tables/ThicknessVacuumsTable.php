<?php

namespace App\Filament\Admin\Resources\ThicknessVacuums\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ThicknessVacuumsTable
{
    protected const VACUUM_LOADS = [
        '-0.1'  => '0 s/d -0.1',
        '-0.25' => '-0.1 s/d -0.25',
        '-0.5'  => '-0.25 s/d -0.5',
        '-1.0'  => '-0.5 s/d -1.0',
    ];

    public static function configure(Table $table): Table
    {
        $loadColumns = collect(self::VACUUM_LOADS)->map(function (string $label, string $load) {
            return TextColumn::make("thickness_{$load}")
                ->label($label)
                ->getStateUsing(function ($record) use ($load) {
                    $found = $record->thicknessVacuums->firstWhere('vacuum_load', $load);
                    return $found ? number_format($found->thickness, 2) . ' mm' : '-';
                })
                ->alignCenter();
        })->values()->toArray();

        return $table
        ->deferLoading()
            ->query(
                \App\Models\MasterDiameter::query()
                    ->with(['thicknessVacuums'])
                    ->whereHas('thicknessVacuums')
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
                ...$loadColumns,
            ])
            ->filters([])
            ->recordActions([]);
    }
}