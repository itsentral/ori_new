<?php

namespace App\Filament\Admin\Resources\MasterMaterials\Pages;

use App\Filament\Admin\Resources\MasterMaterials\MasterMaterialResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMasterMaterial extends EditRecord
{ 
    protected static string $resource = MasterMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return MasterMaterialResource::getEditPageActions();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
