<?php

namespace App\Filament\Admin\Resources\ProductCatalogs\Pages;

use App\Filament\Admin\Resources\ProductCatalogs\ProductCatalogResource;
use Filament\Resources\Pages\ListRecords;

class ListProductCatalogs extends ListRecords
{
    protected static string $resource = ProductCatalogResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
