<?php

namespace App\Filament\Admin\Resources\ProductCatalogs\Tables;

use App\Filament\Admin\Resources\ProductCatalogs\ProductCatalogResource;
use App\Models\ThicknessCalculation;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductCatalogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                ThicknessCalculation::query()->where('layer_selection_status', 'selected')
            )
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
            ])
            ->recordActions([
                Action::make('view_detail')
                    ->label('View Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn($record) => ProductCatalogResource::getUrl('view', ['record' => $record])),
                Action::make('download_excel')
                    ->label('Download Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(fn($record) => route('product-catalog.export', ['record' => $record]))
                    ->openUrlInNewTab(),
            ]);
    }
}
