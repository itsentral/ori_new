<?php

namespace App\Filament\Admin\Resources\MasterDiameters\Pages;

use App\Filament\Admin\Resources\MasterDiameters\MasterDiameterResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMasterDiameter extends CreateRecord
{
    protected static string $resource = MasterDiameterResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

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
