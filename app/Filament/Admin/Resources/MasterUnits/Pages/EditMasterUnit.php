<?php

namespace App\Filament\Admin\Resources\MasterUnits\Pages;

use App\Filament\Admin\Resources\MasterUnits\MasterUnitResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMasterUnit extends EditRecord
{
    protected static string $resource = MasterUnitResource::class;

    protected function getHeaderActions(): array
    {
        return MasterUnitResource::getEditPageActions();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
