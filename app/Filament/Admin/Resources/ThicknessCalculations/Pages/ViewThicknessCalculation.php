<?php

namespace App\Filament\Admin\Resources\ThicknessCalculations\Pages;

use App\Filament\Admin\Resources\ThicknessCalculations\ThicknessCalculationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewThicknessCalculation extends ViewRecord
{
    protected static string $resource = ThicknessCalculationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['application_ids'] = \App\Models\MasterApplication::where('calculation_id', $this->record->id)
            ->pluck('id')
            ->toArray();

        // Re-fill snapshot
        if (empty($data['pn_value_snapshot'])) {
            $pn = \App\Models\MasterPressureNominal::find($data['pressure_nominal_id'] ?? null);
            $data['pn_name_snapshot']  = $pn?->pn_name;
            $data['pn_value_snapshot'] = $pn?->pn_value;
        }

        if (empty($data['liner_code_snapshot'])) {
            $liner = \App\Models\ThicknessLiner::find($data['liner_id'] ?? null);
            $data['liner_code_snapshot']          = $liner?->liner_code;
            $data['liner_material_type_snapshot'] = $liner?->material_type_name;
            $data['liner_thickness_snapshot']     = $liner?->thickness_teori;
        }

        if (empty($data['vacuum_load_snapshot'])) {
        $data['vacuum_load_snapshot'] = $this->record->vacuum_load_snapshot;
    }
    
        return $data;
    }
}
