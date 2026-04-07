<?php

namespace App\Filament\Admin\Resources\MasterStandardEngineerings\Pages;

use App\Filament\Admin\Resources\MasterStandardEngineerings\MasterStandardEngineeringResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMasterStandardEngineering extends EditRecord
{
    protected static string $resource = MasterStandardEngineeringResource::class;

   protected function getHeaderActions(): array
    {
        return MasterStandardEngineeringResource::getEditPageActions();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
