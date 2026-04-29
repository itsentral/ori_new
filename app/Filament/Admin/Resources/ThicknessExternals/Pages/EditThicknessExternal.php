<?php

namespace App\Filament\Admin\Resources\ThicknessExternals\Pages;

use App\Filament\Admin\Resources\ThicknessExternals\ThicknessExternalResource;
use App\Models\ThicknessExternal;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditThicknessExternal extends EditRecord
{
    protected static string $resource = ThicknessExternalResource::class;

    protected function getHeaderActions(): array
    {
        return ThicknessExternalResource::getEditPageActions();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (ThicknessExternal::isDuplicate($data, $this->record->id)) {
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
