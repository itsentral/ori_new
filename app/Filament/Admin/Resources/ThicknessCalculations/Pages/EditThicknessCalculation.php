<?php

namespace App\Filament\Admin\Resources\ThicknessCalculations\Pages;

use App\Filament\Admin\Resources\ThicknessCalculations\ThicknessCalculationResource;
use App\Models\MasterApplication;
use App\Services\ThicknessCalculationService;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditThicknessCalculation extends EditRecord
{
    protected static string $resource = ThicknessCalculationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['application_ids'] = MasterApplication::where('calculation_id', $this->record->id)
            ->pluck('id')
            ->toArray();

        // Re-fill snapshot dari relasi jika kosong
        if (empty($data['pn_name_snapshot']) || empty($data['pn_value_snapshot'])) {
            $pn = \App\Models\MasterPressureNominal::find($data['pressure_nominal_id'] ?? null);
            $data['pn_name_snapshot']  = $pn?->pn_name;
            $data['pn_value_snapshot'] = $pn?->pn_value;
        }

        if (empty($data['liner_code_snapshot'])) {
            $liner = \App\Models\ThicknessLiner::find($data['liner_id'] ?? null);
            $data['liner_code_snapshot']           = $liner?->liner_code;
            $data['liner_material_type_snapshot']  = $liner?->material_type_name;
            $data['liner_thickness_snapshot']      = $liner?->thickness_teori;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Regenerate standard product name
        $parts = array_filter([
            $data['liner_code_snapshot']      ?? null,
            'STRUCT',
            ($data['use_external'] ?? false)
                ? ($data['external_layer_snapshot'] ?? null)
                : null,
            ($data['use_top_coat'] ?? false) ? 'TC' : null,
        ]);

        $data['standard_product_name'] = implode('+', $parts);

        // Reset layer selection status jika parameter berubah
        $data['layer_selection_status'] = 'pending';

        return $data;
    }

    protected function afterSave(): void
    {
        $record      = $this->getRecord();
        $selectedIds = $this->data['application_ids'] ?? [];

        // Lepas aplikasi yang tidak dipilih lagi
        MasterApplication::where('calculation_id', $record->id)
            ->whereNotIn('id', $selectedIds)
            ->update(['calculation_id' => null]);

        // Assign aplikasi baru
        if (!empty($selectedIds)) {
            MasterApplication::whereIn('id', $selectedIds)
                ->update(['calculation_id' => $record->id]);
        }

        // Hapus detail & selection lama lalu regenerate
        $record->layerSelections()->delete();
        $record->details()->delete();

        $service = new ThicknessCalculationService();

        $details = $service->generateDetails([
            'liner_id'            => $record->liner_id,
            'liner_thickness'     => $record->liner_thickness_snapshot,
            'pressure_nominal_id' => $record->pressure_nominal_id,
            'temperature'         => $record->temperature,
            'vacuum_type'         => $record->vacuum_type,
            'vacuum_load'         => $record->vacuum_load_snapshot,
            'stiffness'           => $record->stiffness_snapshot,
            'external_layer'      => $record->use_external
                ? $record->external_layer_snapshot
                : null,
            'use_top_coat'        => $record->use_top_coat,
        ]);

        if (!empty($record->layer_category)) {
            $details = $service->matchLayerForDetails($details, $record->layer_category);
        }

        $record->details()->createMany($details);
    }
}
