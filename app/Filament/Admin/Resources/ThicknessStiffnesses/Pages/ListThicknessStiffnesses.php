<?php

namespace App\Filament\Admin\Resources\ThicknessStiffnesses\Pages;

use App\Filament\Admin\Resources\ThicknessStiffnesses\ThicknessStiffnessResource;
use App\Models\MasterDiameter;
use App\Models\ThicknessStiffness;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class ListThicknessStiffnesses extends ListRecords
{
    protected static string $resource = ThicknessStiffnessResource::class;

    protected const STIFFNESSES = [1250, 2500, 5000, 10000];

    protected function getHeaderActions(): array
    {
        return [
            $this->getMatrixAction(),
        ];
    }

    protected function getMatrixAction(): Action
    {
        return Action::make('inputMatrix')
            ->label('Input Matrix Thickness Stiffness')
            ->color('success')
            ->icon('heroicon-o-table-cells')
            ->modalHeading('Input Matrix Thickness Stiffness')
            ->modalWidth('5xl')
            ->closeModalByClickingAway(false)
            ->fillForm(function (): array {
                $existingData = ThicknessStiffness::all();

                $formData = [];
                foreach ($existingData as $record) {
                    $formData["value_{$record->master_diameter_id}_{$record->stiffness}"] = $record->thickness;
                }

                return $formData;
            })
            ->schema(function () {
                
                $diameters = MasterDiameter::query()
                ->orderByRaw('CAST(diameter_mm AS UNSIGNED) ASC')
                ->get();
                $stiffnesses = self::STIFFNESSES;

                $schema = [];
                foreach ($diameters as $dia) {
                    $gridFields = [
                        TextInput::make("dia_{$dia->id}_label")
                            ->label('Diameter')
                            ->afterStateHydrated(fn($set) => $set("dia_{$dia->id}_label", $dia->diameter_mm . ' mm'))
                            ->disabled()
                            ->dehydrated(false),
                    ];

                    foreach ($stiffnesses as $stiffness) {
                        $fieldKey = "value_{$dia->id}_{$stiffness}";
                        $gridFields[] = TextInput::make($fieldKey)
                            ->label("SN {$stiffness}")
                            ->numeric()
                            ->placeholder('mm');
                    }

                    $schema[] = Grid::make(1 + count($stiffnesses))
                        ->schema($gridFields);
                }

                return $schema;
            })
            ->action(function (array $data): void {
                DB::transaction(function () use ($data): void {
                    foreach ($data as $key => $value) {
                        if (str_starts_with($key, 'value_')) {
                            // Format key: value_{diameter_id}_{stiffness}
                            $parts = explode('_', $key, 3);
                            $diaId    = $parts[1];
                            $stiffness = $parts[2];

                            if (!empty($value)) {
                                ThicknessStiffness::updateOrCreate(
                                    [
                                        'master_diameter_id' => $diaId,
                                        'stiffness'   => $stiffness,
                                    ],
                                    ['thickness' => $value]
                                );
                            } else {
                                ThicknessStiffness::where([
                                    'master_diameter_id' => $diaId,
                                    'stiffness'   => $stiffness,
                                ])->delete();
                            }
                        }
                    }
                });

                Notification::make()
                    ->title('Matrix Thickness Stiffness berhasil disimpan')
                    ->success()
                    ->send();
            });
    }
}