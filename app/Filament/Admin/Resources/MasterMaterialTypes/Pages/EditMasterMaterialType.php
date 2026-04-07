<?php

namespace App\Filament\Admin\Resources\MasterMaterialTypes\Pages;

use App\Filament\Admin\Resources\MasterMaterialTypes\MasterMaterialTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMasterMaterialType extends EditRecord
{
    protected static string $resource = MasterMaterialTypeResource::class;

    protected function getHeaderActions(): array
    {
        return MasterMaterialTypeResource::getEditPageActions();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
