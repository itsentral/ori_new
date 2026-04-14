<?php

namespace App\Filament\Admin\Resources\MasterLayers\Pages;

use App\Filament\Admin\Resources\MasterLayers\MasterLayerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListMasterLayers extends ListRecords
{
    protected static string $resource = MasterLayerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'hand_layup' => Tab::make('Hand Layup')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('category', 'hand_layup')),
            'filament_winding' => Tab::make('Filament Winding')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('category', 'filament_winding')),
        ];
    }
}