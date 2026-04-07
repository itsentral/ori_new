<?php

namespace App\Filament\Admin\Resources\MasterMaterials\Pages;

use App\Filament\Admin\Resources\MasterMaterials\MasterMaterialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMasterMaterials extends ListRecords
{
    protected static string $resource = MasterMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
