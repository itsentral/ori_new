<?php

namespace App\Filament\Admin\Resources\MasterLayers\Pages;

use App\Filament\Admin\Resources\MasterLayers\MasterLayerResource;
use App\Models\MasterLayer;
use Filament\Resources\Pages\CreateRecord;

class CreateMasterLayer extends CreateRecord
{
    protected static string $resource = MasterLayerResource::class;

    public $raw_thicknesses;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $prefix = $data['category'] === 'hand_layup' ? 'HL' : 'FL';
        $lastRecord = MasterLayer::where('category', $data['category'])
            ->latest('id')
            ->first();

        $lastNumber = 0;
        if ($lastRecord && preg_match('/\d+$/', $lastRecord->layer_code, $matches)) {
            $lastNumber = (int) $matches[0];
        }

        $newNumber          = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $data['layer_code'] = $prefix . $newNumber;

        $this->raw_thicknesses = $data['thicknesses'] ?? [];
        unset($data['thicknesses']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->record;

        foreach ($this->raw_thicknesses as $thicknessData) {
            $thickness = $record->thicknesses()->create([
                'thickness' => $thicknessData['thickness'],
            ]);

            foreach ($thicknessData['stages'] ?? [] as $stageIndex => $stageData) {
                $stageNumber = $stageIndex + 1;

                foreach ($stageData['steps'] ?? [] as $stepIndex => $stepData) {
                    $thickness->details()->create([
                        'stage_number'     => $stageNumber,
                        'step_number'      => $stepIndex + 1,
                        'layer_value'      => $stepData['layer_value'] ?? 'Layer ' . ($stepIndex + 1),
                        'material_type_id' => $stepData['material_type_id'] ?? null,
                    ]);
                }
            }
        }
    }
}