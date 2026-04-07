<?php

namespace App\Filament\Admin\Resources\MasterDiameters\Pages;

use App\Filament\Admin\Resources\MasterDiameters\MasterDiameterResource;
use Filament\Resources\Pages\EditRecord;

class EditMasterDiameter extends EditRecord
{
    protected static string $resource = MasterDiameterResource::class;

    protected function getHeaderActions(): array
    {
        return MasterDiameterResource::getEditPageActions();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
