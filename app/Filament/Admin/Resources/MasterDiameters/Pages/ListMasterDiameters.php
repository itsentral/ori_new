<?php

namespace App\Filament\Admin\Resources\MasterDiameters\Pages;

use App\Filament\Admin\Resources\MasterDiameters\MasterDiameterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMasterDiameters extends ListRecords
{
    protected static string $resource = MasterDiameterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
