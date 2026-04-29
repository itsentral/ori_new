<?php

namespace App\Filament\Admin\Resources\ThicknessExternals\Pages;

use App\Filament\Admin\Resources\ThicknessExternals\ThicknessExternalResource;
use App\Models\ThicknessExternal;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateThicknessExternal extends CreateRecord
{
    protected static string $resource = ThicknessExternalResource::class;

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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (ThicknessExternal::isDuplicate($data)) {
            Notification::make()
                ->title('Data sudah ada!')
                ->body('Kombinasi Resin Type, Thickness, dan Formula Layer sudah terdaftar.')
                ->danger()
                ->persistent()
                ->send();

            $this->halt();
        }

        return $data;
    }
}