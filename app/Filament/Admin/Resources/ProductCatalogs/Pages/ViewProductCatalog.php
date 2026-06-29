<?php

namespace App\Filament\Admin\Resources\ProductCatalogs\Pages;

use App\Filament\Admin\Resources\ProductCatalogs\ProductCatalogResource;
use App\Models\ThicknessCalculation;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;

class ViewProductCatalog extends Page
{
    protected string $view = 'filament.admin.resources.product-catalogs.pages.view-product-catalog';
    protected static string $resource = ProductCatalogResource::class;

    public ThicknessCalculation $record;

    public function mount(ThicknessCalculation $record): void
    {
        $this->record = $record;
    }

    public function getTitle(): string
    {
        return "Product Catalog — {$this->record->brand_name}";
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-m-arrow-left')
                ->color('gray')
                ->url(ProductCatalogResource::getUrl('index')),
            Action::make('export')
                ->label('Download Excel')
                ->icon('heroicon-m-arrow-down-tray')
                ->color('success')
                ->url(fn() => route('product-catalog.export', ['record' => $this->record]))
                ->openUrlInNewTab(),
        ];
    }
}
