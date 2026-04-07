<?php

namespace App\Filament\Admin\Resources\ThicknessPressureTemps\Pages;

use App\Filament\Admin\Resources\ThicknessPressureTemps\ThicknessPressureTempResource;
use App\Models\ThicknessPressureTemp;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class CreateThicknessPressureTemp extends CreateRecord
{
    protected static string $resource = ThicknessPressureTempResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $items       = $data['thickness_items'] ?? [];
        $diameterId  = $data['master_diameter_id'];
        $temperature = $data['temperature'];

        $duplicates = [];
        foreach ($items as $item) {
            $exists = ThicknessPressureTemp::withoutTrashed()
                ->where('master_diameter_id', $diameterId)
                ->where('temperature', $temperature)
                ->where('master_pressure_nominal_id', $item['master_pressure_nominal_id'])
                ->exists();

            if ($exists) {
                $duplicates[] = $item['master_pressure_nominal_id'];
            }
        }

        if (!empty($duplicates)) {
            Notification::make()
                ->title('Data sudah ada')
                ->body('Terdapat kombinasi Diameter, Temperature, dan PN yang sudah ada di database.')
                ->danger()
                ->send();

            throw ValidationException::withMessages([
                'thickness_items' => 'Terdapat duplikat PN.',
            ]);
        }

        $record = null;
        foreach ($items as $item) {
            $record = ThicknessPressureTemp::create([
                'master_diameter_id'         => $diameterId,
                'temperature'                => $temperature,
                'master_pressure_nominal_id' => $item['master_pressure_nominal_id'],
                'thickness'                  => $item['thickness'],
            ]);
        }

        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
