<?php

namespace App\Filament\Admin\Resources\MasterLayers\Pages;

use App\Filament\Admin\Resources\MasterLayers\MasterLayerResource;
use App\Models\MasterLayerThickness;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMasterLayer extends EditRecord
{
    protected static string $resource = MasterLayerResource::class;

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
        $thicknesses = MasterLayerThickness::where('master_layer_id', $data['id'])
            ->with('details.materialType')
            ->get();

        $data['thicknesses'] = $thicknesses->map(function ($thickness) {
            $groupedStages = $thickness->details->groupBy('stage_number');

            $stages = $groupedStages->map(function ($steps) {
                return [
                    'steps' => $steps->map(fn($step) => [
                        'step_number'      => $step->step_number,
                        'layer_value'      => $step->layer_value,
                        'material_type_id' => $step->material_type_id,
                        'type_code'        => $step->materialType?->type_code,
                    ])->toArray(),
                ];
            })->values()->toArray();

            return [
                'thickness' => $thickness->thickness,
                'stages'    => $stages,
            ];
        })->toArray();

        return $data;
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        $thicknessesData = $data['thicknesses'] ?? [];
        unset($data['thicknesses']);

        // Clear diameter_id_2 jika operator bukan between
        if ($data['operator'] !== 'between') {
            $data['diameter_id_2'] = null;
        }

        $record->update($data);

        // $record->thicknesses()->each(function ($thickness) {
        //     $thickness->details()->delete();
        //     $thickness->delete();
        // });

        $record->thicknesses()->each(function ($thickness) {
            $thickness->details()->forceDelete();
            $thickness->forceDelete();
        });

        foreach ($thicknessesData as $thicknessData) {
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

        return $record;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
