<?php

namespace App\Filament\Admin\Resources\ThicknessLiners\Pages;

use App\Filament\Admin\Resources\ThicknessLiners\ThicknessLinerResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\ThicknessLiner;
use Filament\Notifications\Notification;

class CreateThicknessLiner extends CreateRecord
{
    protected static string $resource = ThicknessLinerResource::class;

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
        if (ThicknessLiner::isDuplicate($data)) {
            Notification::make()
                ->title('Data sudah ada!')
                ->body('Kombinasi Corrosion, Temperature, Resin Type, Thickness, dan Formula Layer sudah terdaftar.')
                ->danger()
                ->persistent()
                ->send();

            $this->halt(); // Hentikan proses simpan
        }

        return $data;
    }
}
