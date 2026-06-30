<?php

namespace App\Filament\Admin\Resources\ProductCatalogs;

use App\Filament\Admin\Resources\BaseResource;
use App\Filament\Admin\Resources\ProductCatalogs\Pages\ListProductCatalogs;
use App\Filament\Admin\Resources\ProductCatalogs\Pages\ViewProductCatalog;
use App\Filament\Admin\Resources\ProductCatalogs\Schemas\ProductCatalogInfolist;
use App\Filament\Admin\Resources\ProductCatalogs\Tables\ProductCatalogsTable;
use App\Models\ThicknessCalculation;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
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

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductCatalogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductCatalogsTable::configure($table);
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
