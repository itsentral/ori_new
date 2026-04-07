<?php

namespace App\Filament\Admin\Resources\ThicknessPressureTemps\Pages;

use App\Filament\Admin\Resources\ThicknessPressureTemps\ThicknessPressureTempResource;
use Filament\Resources\Pages\EditRecord;

class EditThicknessPressureTemp extends EditRecord
{
    protected static string $resource = ThicknessPressureTempResource::class;

    protected function getHeaderActions(): array
    {
        return ThicknessPressureTempResource::getEditPageActions();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
