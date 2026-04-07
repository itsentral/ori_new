<?php

namespace App\Filament\Admin\Resources\ThicknessStiffnesses\Pages;

use App\Filament\Admin\Resources\ThicknessStiffnesses\ThicknessStiffnessResource;
use Filament\Resources\Pages\CreateRecord;

class CreateThicknessStiffness extends CreateRecord
{
    protected static string $resource = ThicknessStiffnessResource::class;
    
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
