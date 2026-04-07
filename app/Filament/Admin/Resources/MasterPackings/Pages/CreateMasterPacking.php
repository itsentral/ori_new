<?php

namespace App\Filament\Admin\Resources\MasterPackings\Pages;

use App\Filament\Admin\Resources\MasterPackings\MasterPackingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMasterPacking extends CreateRecord
{
    protected static string $resource = MasterPackingResource::class;

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
