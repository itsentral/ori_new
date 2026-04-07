<?php

namespace App\Filament\Admin\Resources\ThicknessVacuums\Pages;

use App\Filament\Admin\Resources\ThicknessVacuums\ThicknessVacuumResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditThicknessVacuum extends EditRecord
{
    protected static string $resource = ThicknessVacuumResource::class;

    protected function getHeaderActions(): array
    {
        return ThicknessVacuumResource::getEditPageActions();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
