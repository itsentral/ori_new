<?php

namespace App\Filament\Admin\Resources\ThicknessPressureTemps\Pages;

use App\Filament\Admin\Resources\ThicknessPressureTemps\ThicknessPressureTempResource;
use App\Models\MasterDiameter;
use App\Models\MasterPressureNominal;
use App\Models\ThicknessPressureTemp;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ListThicknessPressureTemps extends ListRecords
{
    protected static string $resource = ThicknessPressureTempResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->getMatrixAction('65deg', '65°C'),
            $this->getMatrixAction('80deg', '80°C'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            '65deg' => Tab::make('65°C')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->with([
                            'thicknessPressureTemps' => fn($q) => $q->where('temperature', '65deg'),
                        ])
                        ->whereHas('thicknessPressureTemps', fn($q) => $q->where('temperature', '65deg'))
                ),

            '80deg' => Tab::make('80°C')
                ->modifyQueryUsing(
                    fn(Builder $query) => $query
                        ->with([
                            'thicknessPressureTemps' => fn($q) => $q->where('temperature', '80deg'),
                        ])
                        ->whereHas('thicknessPressureTemps', fn($q) => $q->where('temperature', '80deg'))
                ),
        ];
    }

    protected function getMatrixAction(string $tempKey, string $label): Action
    {
        return Action::make('importMatrix_' . $tempKey)
            ->label('Input Matrix ' . $label)
            ->color('success')
            ->icon('heroicon-o-table-cells')
            ->modalHeading('Input Thickness Matrix - ' . $label)
            ->modalWidth('7xl')
            ->closeModalByClickingAway(false)
            ->fillForm(function () use ($tempKey): array {
                $existingData = ThicknessPressureTemp::where('temperature', $tempKey)->get();

                $formData = [];
                foreach ($existingData as $record) {
                    $formData["value_{$record->master_diameter_id}_{$record->master_pressure_nominal_id}"] = $record->thickness;
                }

                return $formData;
            })
            ->schema(function () {
                $diameters = MasterDiameter::query()
                            ->orderByRaw('CAST(diameter_mm AS UNSIGNED) ASC')
                            ->get();
                $pns = MasterPressureNominal::query()
                    ->orderByRaw('LENGTH(pn_name) ASC')
                    ->orderBy('pn_name', 'asc')
                    ->get();

                $schema = [];
                foreach ($diameters as $dia) {
                    $gridFields = [
                        TextInput::make("dia_{$dia->id}_label")
                            ->label('Diameter')
                            ->afterStateHydrated(fn($set) => $set("dia_{$dia->id}_label", $dia->diameter_mm . ' mm'))
                            ->disabled()
                            ->dehydrated(false),
                    ];

                    foreach ($pns as $pn) {
                        $gridFields[] = TextInput::make("value_{$dia->id}_{$pn->id}")
                            ->label($pn->pn_name)
                            ->numeric()
                            ->placeholder('mm');
                    }

                    $schema[] = Grid::make(1 + $pns->count())
                        ->schema($gridFields);
                }

                return $schema;
            })
            ->action(function (array $data) use ($tempKey): void {
                DB::transaction(function () use ($data, $tempKey): void {
                    foreach ($data as $key => $value) {
                        if (str_starts_with($key, 'value_')) {
                            $parts = explode('_', $key);
                            $diaId = $parts[1];
                            $pnId  = $parts[2];

                            if (!empty($value)) {
                                // Simpan atau update jika ada nilai
                                ThicknessPressureTemp::updateOrCreate(
                                    [
                                        'master_diameter_id'         => $diaId,
                                        'master_pressure_nominal_id' => $pnId,
                                        'temperature'                => $tempKey,
                                    ],
                                    ['thickness' => $value]
                                );
                            } else {
                                // Hapus jika dikosongkan
                                ThicknessPressureTemp::where([
                                    'master_diameter_id'         => $diaId,
                                    'master_pressure_nominal_id' => $pnId,
                                    'temperature'                => $tempKey,
                                ])->delete();
                            }
                        }
                    }
                });

                Notification::make()
                    ->title('Matrix berhasil disimpan')
                    ->success()
                    ->send();
            });
    }
}
