<?php

namespace App\Filament\Admin\Resources\MasterThicknessExternals\Pages;

use App\Filament\Admin\Resources\MasterThicknessExternals\MasterThicknessExternalResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMasterThicknessExternal extends CreateRecord
{
    protected static string $resource = MasterThicknessExternalResource::class;

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
