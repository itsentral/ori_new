<?php

namespace App\Filament\Admin\Resources\MasterMaterialTypes\Pages;

use App\Filament\Admin\Resources\MasterMaterialTypes\MasterMaterialTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMasterMaterialType extends CreateRecord
{
    protected static string $resource = MasterMaterialTypeResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction()
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
