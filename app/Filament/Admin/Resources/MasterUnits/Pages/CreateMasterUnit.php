<?php

namespace App\Filament\Admin\Resources\MasterUnits\Pages;

use App\Filament\Admin\Resources\MasterUnits\MasterUnitResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMasterUnit extends CreateRecord
{
    protected static string $resource = MasterUnitResource::class;

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
