<?php

namespace App\Filament\Admin\Resources\MasterUnits\Pages;

use App\Filament\Admin\Resources\MasterUnits\MasterUnitResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMasterUnits extends ListRecords
{
    protected static string $resource = MasterUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
