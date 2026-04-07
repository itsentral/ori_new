<?php

namespace App\Filament\Admin\Resources\MasterStandardEngineerings\Pages;

use App\Filament\Admin\Resources\MasterStandardEngineerings\MasterStandardEngineeringResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMasterStandardEngineering extends CreateRecord
{
    protected static string $resource = MasterStandardEngineeringResource::class;

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
