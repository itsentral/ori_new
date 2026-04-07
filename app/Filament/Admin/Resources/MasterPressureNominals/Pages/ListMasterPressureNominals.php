<?php

namespace App\Filament\Admin\Resources\MasterPressureNominals\Pages;

use App\Filament\Admin\Resources\MasterPressureNominals\MasterPressureNominalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMasterPressureNominals extends ListRecords
{
    protected static string $resource = MasterPressureNominalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
