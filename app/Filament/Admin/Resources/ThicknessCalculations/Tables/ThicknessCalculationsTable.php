<?php

namespace App\Filament\Admin\Resources\ThicknessCalculations\Tables;

use App\Filament\Admin\Resources\ThicknessCalculations\ThicknessCalculationResource;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ThicknessCalculationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('brand_name')
                    ->label('Brand Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('liner_id')
                    ->label('Liner')
                    ->formatStateUsing(function ($record) {
                        $liner = $record->liner;
                        if (!$liner) {
                            return '-';
                        }
                        $corrosionMap = [1 => 'Low', 2 => 'Medium', 3 => 'High'];
                        $tempMap = [1 => 'Low', 2 => 'Medium', 3 => 'High'];
                        $corrosion = $corrosionMap[$liner->corrosion] ?? '-';
                        $temp = $tempMap[$liner->temprature] ?? '-';
                        return "Corrosion: {$corrosion} | Temp: {$temp}";
                    }),
                TextColumn::make('temperature')
                    ->label('Temp')
                    ->formatStateUsing(fn($state) => $state == 80 ? '>80°C' : '65°C'),
                TextColumn::make('pn_name_snapshot')
                    ->label('PN'),
                TextColumn::make('vacuum_type')
                    ->label('Vacuum')
                    ->formatStateUsing(fn($state) => ucfirst($state)),
                TextColumn::make('stiffness_snapshot')
                    ->label('SN')
                    ->formatStateUsing(fn($state) => 'SN' . $state),
                TextColumn::make('external_thickness_snapshot')
                    ->label('External')
                    ->default('-'),
                TextColumn::make('use_top_coat')
                    ->label('Top Coat')
                    ->formatStateUsing(fn($state) => $state ? 'Yes' : 'No'),
                TextColumn::make('applications.application_name')
                    ->label('Applications')
                    ->badge()
                    ->separator(', '),
                TextColumn::make('creator.full_name')
                    ->label('Dibuat oleh')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                ...ThicknessCalculationResource::getRecordActions(),

                Action::make('view_thickness')
                    ->label('Lihat Thickness')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->visible(fn($record) => $record->layer_selection_status === 'selected')
                    ->url(fn($record) => ThicknessCalculationResource::getUrl('process-thickness', ['record' => $record])),

                Action::make('proses_thickness')
                    ->label('Proses Thickness')
                    ->icon('heroicon-o-cog')
                    ->color('warning')
                    // ->visible(fn($record) => $record->layer_selection_status === 'pending')
                    ->url(fn($record) => ThicknessCalculationResource::getUrl('process-thickness', ['record' => $record]))
                    
            ]);
    }
}
