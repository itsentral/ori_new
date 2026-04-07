<?php

namespace App\Filament\Admin\Resources\MasterThicknessExternals\Pages;

use App\Filament\Admin\Resources\MasterThicknessExternals\MasterThicknessExternalResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMasterThicknessExternal extends EditRecord
{
    protected static string $resource = MasterThicknessExternalResource::class;

     protected function getHeaderActions(): array
    {
        return MasterThicknessExternalResource::getEditPageActions();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
