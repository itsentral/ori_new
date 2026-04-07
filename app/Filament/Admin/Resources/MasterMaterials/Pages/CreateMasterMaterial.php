<?php

namespace App\Filament\Admin\Resources\MasterMaterials\Pages;

use App\Filament\Admin\Resources\MasterMaterials\MasterMaterialResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMasterMaterial extends CreateRecord
{
    protected static string $resource = MasterMaterialResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction(),
        ];
    } 

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
