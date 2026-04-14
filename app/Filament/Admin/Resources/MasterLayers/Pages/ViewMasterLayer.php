<?php

namespace App\Filament\Admin\Resources\MasterLayers\Pages;

use App\Filament\Admin\Resources\MasterLayers\MasterLayerResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMasterLayer extends ViewRecord
{
    protected static string $resource = MasterLayerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // 1. Ambil data detail beserta relasi material-nya
        $details = \App\Models\MasterLayerDetail::with('materialType')
            ->where('layer_id', $data['id'])
            ->get()
            ->groupBy('stage_number');

        $stages = [];

        // 2. Susun kembali struktur array agar sesuai dengan nested repeater di Schema
        foreach ($details as $stageNumber => $steps) {
            $stages[] = [
                'steps' => $steps->map(fn($step) => [
                    'step_number' => $step->step_number,
                    'layer_value' => $step->layer_value,
                    'material_type_id' => $step->material_type_id,
                    'type_code' => $step->materialType?->type_code, // Agar type code muncul di view
                ])->toArray()
            ];
        }

        // 3. Masukkan ke dalam key 'stages' sesuai nama field di form/schema
        $data['stages'] = $stages;

        return $data;
    }
}
