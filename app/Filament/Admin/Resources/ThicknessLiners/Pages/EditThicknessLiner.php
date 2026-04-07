<?php

namespace App\Filament\Admin\Resources\ThicknessLiners\Pages;

use App\Filament\Admin\Resources\ThicknessLiners\ThicknessLinerResource;
use App\Models\ThicknessLiner;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditThicknessLiner extends EditRecord
{
    protected static string $resource = ThicknessLinerResource::class;

    protected function getHeaderActions(): array
    {
        return ThicknessLinerResource::getEditPageActions();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (ThicknessLiner::isDuplicate($data, $this->record->id)) {
            Notification::make()
                ->title('Data sudah ada!')
                ->body('Kombinasi Formula sudah terdaftar.')
                ->danger()
                ->persistent()
                ->send();

            $this->halt();
        }

        return $data;
    }
}
