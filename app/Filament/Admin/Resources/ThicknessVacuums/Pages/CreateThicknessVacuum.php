<?php

namespace App\Filament\Admin\Resources\ThicknessVacuums\Pages;

use App\Filament\Admin\Resources\ThicknessVacuums\ThicknessVacuumResource;
use App\Models\ThicknessVacuum;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class CreateThicknessVacuum extends CreateRecord
{
    protected static string $resource = ThicknessVacuumResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        $items      = $data['vacuum_items'] ?? [];
        $diameterid = $data['master_diameter_id'];
        $vacuumType = $data['vacuum_type'];

        // Validasi duplikat sebelum insert
        $duplicates = [];
        foreach ($items as $item) {
            $exists = ThicknessVacuum::withoutTrashed()
                ->where('master_diameter_id', $diameterid)
                ->where('vacuum_type', $vacuumType)
                ->where('vacuum_load', $item['vacuum_load'])
                ->exists();

            if ($exists) {
                $duplicates[] = $item['vacuum_load'];
            }
        }

        if (!empty($duplicates)) {
            Notification::make()
                ->title('Data sudah ada')
                ->body('Vacuum load berikut sudah memiliki data: ' . implode(', ', $duplicates))
                ->danger()
                ->send();

            // Hentikan proses create
            throw ValidationException::withMessages([
                'vacuum_items' => 'Terdapat duplikat vacuum load.',
            ]);
        }

        $record = null;
        foreach ($items as $item) {
            $record = ThicknessVacuum::create([
                'master_diameter_id' => $diameterid,
                'vacuum_type'        => $vacuumType,
                'vacuum_load'        => $item['vacuum_load'],
                'thickness'          => $item['thickness'],
            ]);
        }

        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
