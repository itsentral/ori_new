<?php

namespace App\Filament\Admin\Resources\MasterPressureNominals\Pages;

use App\Filament\Admin\Resources\MasterPressureNominals\MasterPressureNominalResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMasterPressureNominal extends EditRecord
{
    protected static string $resource = MasterPressureNominalResource::class;

    protected function getHeaderActions(): array
    {
        return MasterPressureNominalResource::getEditPageActions();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
