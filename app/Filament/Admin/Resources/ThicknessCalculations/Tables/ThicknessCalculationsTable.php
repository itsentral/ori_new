<?php

namespace App\Filament\Admin\Resources\ThicknessCalculations\Tables;

use App\Filament\Admin\Resources\ThicknessCalculations\ThicknessCalculationResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ThicknessCalculationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('brand_name')
                    ->label('Brand Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('standard_product_name')
                    ->label('Standard Product Name')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('liner_code_snapshot')
                    ->label('Liner'),
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
                TextColumn::make('applications_count')
                    ->label('Applications')
                    ->counts('applications'),
                TextColumn::make('creator.full_name')
                    ->label('Dibuat oleh')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
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
