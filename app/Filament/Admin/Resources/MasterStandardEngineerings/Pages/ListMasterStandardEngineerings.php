<?php

namespace App\Filament\Admin\Resources\MasterStandardEngineerings\Pages;

use App\Filament\Admin\Resources\MasterStandardEngineerings\MasterStandardEngineeringResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMasterStandardEngineerings extends ListRecords
{
    protected static string $resource = MasterStandardEngineeringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
