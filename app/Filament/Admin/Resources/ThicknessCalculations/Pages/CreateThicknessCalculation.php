<?php

namespace App\Filament\Admin\Resources\ThicknessCalculations\Pages;

use App\Filament\Admin\Resources\ThicknessCalculations\ThicknessCalculationResource;
use App\Services\ThicknessCalculationService;
use Filament\Resources\Pages\CreateRecord;

class CreateThicknessCalculation extends CreateRecord
{
    protected static string $resource = ThicknessCalculationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate standard product name
        $parts = array_filter([
            $data['liner_code_snapshot']      ?? null,
            'STRUCT',
            ($data['use_external'] ?? false)
                ? ($data['external_code_snapshot'] ?? null)
                : null,
            ($data['use_top_coat'] ?? false) ? 'TC' : null,
        ]);

        if (!empty($data['vacuum_load_snapshot'])) {
            $data['vacuum_load_snapshot'] = number_format((float) $data['vacuum_load_snapshot'], 2);
        }

        $data['standard_product_name'] = implode('+', $parts);

        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->getRecord();
        $data   = $this->data;

        $service = new ThicknessCalculationService();

        // Generate details per diameter
        $details = $service->generateDetails([
            'liner_id'            => $record->liner_id,
            'liner_thickness'     => $record->liner_thickness_snapshot,
            'pressure_nominal_id' => $record->pressure_nominal_id,
            'temperature'         => $record->temperature,
            'vacuum_type'         => $record->vacuum_type,
            'vacuum_load'         => $record->vacuum_load_snapshot,
            'stiffness'           => $record->stiffness_snapshot,
            'use_external'        => $record->use_external,
            'external_thickness'  => $record->external_thickness_snapshot,
            'use_top_coat'        => $record->use_top_coat,
        ]);

        // Match layer untuk setiap detail
        if (!empty($record->layer_category)) {
            $details = $service->matchLayerForDetails($details, $record->layer_category);
        }

        $record->details()->createMany($details);

        // Assign applications
        $selectedIds = $data['application_ids'] ?? [];
        if (!empty($selectedIds)) {
            $record->applications()->sync($selectedIds);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
