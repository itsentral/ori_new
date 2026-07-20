<?php

namespace App\Filament\Admin\Resources\MasterTechnologies\Pages;

use App\Filament\Admin\Resources\MasterTechnologies\MasterTechnologyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMasterTechnologies extends ListRecords
{
    protected static string $resource = MasterTechnologyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
