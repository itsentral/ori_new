<?php

namespace App\Filament\Admin\Resources\ThicknessStiffnesses\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ThicknessStiffnessesTable
{
    protected const STIFFNESSES = [1250, 2500, 5000, 10000];

    public static function configure(Table $table): Table
    {
        $stiffnessColumns = collect(self::STIFFNESSES)->map(function (int $stiffness) {
            return TextColumn::make("thickness_{$stiffness}")
                ->label("SN {$stiffness}")
                ->getStateUsing(function ($record) use ($stiffness) {
                    $found = $record->thicknessStiffnesses->firstWhere('stiffness', $stiffness);
                    return $found ? number_format($found->thickness, 2) . ' mm' : '-';
                })
                ->alignCenter();
        })->toArray();

        return $table
            ->deferLoading()
            ->query(
                \App\Models\MasterDiameter::query()
                    ->with(['thicknessStiffnesses'])
                    ->whereHas('thicknessStiffnesses')
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
                ...$stiffnessColumns,
            ])
            ->filters([]);
    }
}