<?php

namespace App\Filament\Admin\Resources\ThicknessStiffnesses\Pages;

use App\Filament\Admin\Resources\ThicknessStiffnesses\ThicknessStiffnessResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditThicknessStiffness extends EditRecord
{
    protected static string $resource = ThicknessStiffnessResource::class;

    protected function getHeaderActions(): array
    {
        return ThicknessStiffnessResource::getEditPageActions();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
