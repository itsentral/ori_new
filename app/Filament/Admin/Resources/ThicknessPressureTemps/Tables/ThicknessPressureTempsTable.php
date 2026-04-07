<?php

namespace App\Filament\Admin\Resources\ThicknessPressureTemps\Tables;

use App\Filament\Admin\Resources\ThicknessPressureTemps\ThicknessPressureTempResource;
use App\Models\MasterPressureNominal;
use App\Models\ThicknessPressureTemp;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ThicknessPressureTempsTable
{
    public static function configure(Table $table): Table
    {
        $pns = MasterPressureNominal::query()
            ->orderByRaw('LENGTH(pn_name) ASC')
            ->orderBy('pn_name', 'asc')
            ->get();

        $pnColumns = $pns->map(function ($pn) {
            return TextColumn::make("thickness_{$pn->id}")
                ->label($pn->pn_name)
                ->getStateUsing(function ($record) use ($pn) {
                    $found = $record->thicknessPressureTemps->firstWhere('master_pressure_nominal_id', $pn->id);
                    return $found ? number_format($found->thickness, 2) . ' mm' : '-';
                })
                ->alignCenter();
        })->toArray();

        return $table
            ->deferLoading()
            ->query(
                \App\Models\MasterDiameter::query()
                    ->with(['thicknessPressureTemps'])
                    ->whereHas('thicknessPressureTemps')
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
                ...$pnColumns,
            ])
            ->filters([])
            ->recordActions([]);
    }
}
