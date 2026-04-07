<?php

namespace App\Filament\Admin\Resources\MasterThicknessExternals\Pages;

use App\Filament\Admin\Resources\MasterThicknessExternals\MasterThicknessExternalResource;
use App\Models\MasterDiameter;
use App\Models\MasterThicknessExternal;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class ListMasterThicknessExternals extends ListRecords
{
    protected static string $resource = MasterThicknessExternalResource::class;

    protected const LAYERS = ['1V', '1M', '1M1V'];

    protected function getHeaderActions(): array
    {
        return [
            $this->getMatrixAction(),
        ];
    }

    protected function getMatrixAction(): Action
    {
        return Action::make('inputMatrix')
            ->label('Input Matrix Thickness External')
            ->color('success')
            ->icon('heroicon-o-table-cells')
            ->modalHeading('Input Matrix Thickness External')
            ->modalWidth('5xl')
            ->closeModalByClickingAway(false)
            ->fillForm(function (): array {
                $existingData = MasterThicknessExternal::all();

                $formData = [];
                foreach ($existingData as $record) {
                    $formData["value_{$record->diameter_id}_{$record->layer}"] = $record->thickness;
                }

                return $formData;
            })
            ->schema(function () {
                $diameters = MasterDiameter::orderBy('diameter_mm')->get();
                $layers = self::LAYERS;

                $schema = [];
                foreach ($diameters as $dia) {
                    $gridFields = [
                        TextInput::make("dia_{$dia->id}_label")
                            ->label('Diameter')
                            ->afterStateHydrated(fn($set) => $set("dia_{$dia->id}_label", $dia->diameter_mm . ' mm'))
                            ->disabled()
                            ->dehydrated(false),
                    ];

                    foreach ($layers as $layer) {
                        $fieldKey = "value_{$dia->id}_{$layer}";
                        $gridFields[] = TextInput::make($fieldKey)
                            ->label($layer)
                            ->numeric()
                            ->placeholder('mm');
                    }

                    $schema[] = Grid::make(1 + count($layers))
                        ->schema($gridFields);
                }

                return $schema;
            })
            ->action(function (array $data): void {
                DB::transaction(function () use ($data): void {
                    foreach ($data as $key => $value) {
                        if (str_starts_with($key, 'value_')) {
                            // Format key: value_{diameter_id}_{layer}
                            // Layer bisa mengandung angka & huruf, jadi explode dengan batas 3
                            $parts = explode('_', $key, 3);
                            $diaId = $parts[1];
                            $layer = $parts[2];

                            if (!empty($value)) {
                                MasterThicknessExternal::updateOrCreate(
                                    [
                                        'diameter_id' => $diaId,
                                        'layer'       => $layer,
                                    ],
                                    ['thickness' => $value]
                                );
                            } else {
                                MasterThicknessExternal::where([
                                    'diameter_id' => $diaId,
                                    'layer'       => $layer,
                                ])->delete();
                            }
                        }
                    }
                });

                Notification::make()
                    ->title('Matrix Thickness External berhasil disimpan')
                    ->success()
                    ->send();
            });
    }
}