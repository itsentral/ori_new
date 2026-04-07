<?php

namespace App\Filament\Admin\Resources\MasterPackings\Pages;

use App\Filament\Admin\Resources\MasterPackings\MasterPackingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMasterPacking extends EditRecord
{
    protected static string $resource = MasterPackingResource::class;

    protected function getHeaderActions(): array
    {
        return MasterPackingResource::getEditPageActions();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
