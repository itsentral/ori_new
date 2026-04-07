<?php

namespace App\Filament\Admin\Resources\MasterPressureNominals\Pages;

use App\Filament\Admin\Resources\MasterPressureNominals\MasterPressureNominalResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMasterPressureNominal extends CreateRecord
{
    protected static string $resource = MasterPressureNominalResource::class;

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
