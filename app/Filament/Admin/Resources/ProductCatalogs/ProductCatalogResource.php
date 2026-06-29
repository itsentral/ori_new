<?php

namespace App\Filament\Admin\Resources\ProductCatalogs;

use App\Filament\Admin\Resources\BaseResource;
use App\Filament\Admin\Resources\ProductCatalogs\Pages\ListProductCatalogs;
use App\Filament\Admin\Resources\ProductCatalogs\Pages\ViewProductCatalog;
use App\Models\ThicknessCalculation;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class ProductCatalogResource extends BaseResource
{
    protected static ?string $model = ThicknessCalculation::class;

    protected static ?int $navigationSort = 9;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $recordTitleAttribute = 'brand_name';

    protected static function getPermissionName(): string
    {
        return 'product_catalog';
    }

    public static function table(Table $table): Table
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
                    ->url(fn($record) => static::getUrl('view', ['record' => $record])),
            ]);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductCatalogs::route('/'),
            'view'  => ViewProductCatalog::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('layer_selection_status', 'selected');
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Developing Product';
    }

    public static function getNavigationLabel(): string
    {
        return 'Product Catalog';
    }

    public static function getModelLabel(): string
    {
        return 'Product Catalog';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Product Catalog Piping Standard';
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
