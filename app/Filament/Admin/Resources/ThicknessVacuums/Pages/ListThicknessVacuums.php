<?php

namespace App\Filament\Admin\Resources\ThicknessVacuums\Pages;

use App\Filament\Admin\Resources\ThicknessVacuums\ThicknessVacuumResource;
use App\Models\MasterDiameter;
use App\Models\ThicknessVacuum;
use Filament\Actions\Action;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ListThicknessVacuums extends ListRecords
{
    protected static string $resource = ThicknessVacuumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->getVacuumMatrixAction('Intermittent', 'Matrix Intermittent'),
            $this->getVacuumMatrixAction('Continuous', 'Matrix Continuous'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Intermittent' => Tab::make('Intermittent')
                ->modifyQueryUsing(fn(Builder $query) => $query
                    ->with([
                        'thicknessVacuums' => fn($q) => $q->where('vacuum_type', 'Intermittent'),
                    ])
                    ->whereHas('thicknessVacuums', fn($q) => $q->where('vacuum_type', 'Intermittent'))
                ),

            'Continuous' => Tab::make('Continuous')
                ->modifyQueryUsing(fn(Builder $query) => $query
                    ->with([
                        'thicknessVacuums' => fn($q) => $q->where('vacuum_type', 'Continuous'),
                    ])
                    ->whereHas('thicknessVacuums', fn($q) => $q->where('vacuum_type', 'Continuous'))
                ),
        ];
    }

    protected function getVacuumMatrixAction(string $type, string $label): Action
    {
        $vacuumLoads = [
            'neg0dot1'  => ['label' => '0 s/d -0.1',     'value' => '-0.1'],
            'neg0dot25' => ['label' => '-0.1 s/d -0.25', 'value' => '-0.25'],
            'neg0dot5'  => ['label' => '-0.25 s/d -0.5', 'value' => '-0.5'],
            'neg1dot0'  => ['label' => '-0.5 s/d -1.0',  'value' => '-1.0'],
        ];

        $reverseMap = array_combine(
            array_column($vacuumLoads, 'value'),
            array_keys($vacuumLoads)
        );

        return Action::make('vacuumMatrix_' . $type)
            ->label($label)
            ->color('success')
            ->icon('heroicon-o-table-cells')
            ->modalHeading("Edit / Input Thickness Vacuum ($type)")
            ->modalWidth('7xl')
            ->closeModalByClickingAway(false)
            ->fillForm(function () use ($type, $reverseMap): array {
                $existingData = ThicknessVacuum::where('vacuum_type', $type)->get();

                $formData = [];
                foreach ($existingData as $record) {
                    $encodedLoad = $reverseMap[$record->vacuum_load] ?? null;
                    if ($encodedLoad) {
                        $formData["value_{$record->master_diameter_id}_{$encodedLoad}"] = $record->thickness;
                    }
                }

                return $formData;
            })
            ->schema(function () use ($vacuumLoads): array {
                $diameters = MasterDiameter::query()
                ->orderByRaw('CAST(diameter_mm AS UNSIGNED) ASC')
                ->get();
                $schema    = [];

                foreach ($diameters as $dia) {
                    $gridFields = [
                        TextInput::make("dia_{$dia->id}_label")
                            ->label('Diameter')
                            ->afterStateHydrated(function ($component) use ($dia) {
                                $component->state($dia->diameter_mm . ' mm');
                            })
                            ->disabled()
                            ->dehydrated(false),
                    ];

                    foreach ($vacuumLoads as $encodedKey => $load) {
                        $gridFields[] = TextInput::make("value_{$dia->id}_{$encodedKey}")
                            ->label($load['label'])
                            ->numeric()
                            ->extraInputAttributes(['style' => 'text-align: center;'])
                            ->placeholder('-');
                    }

                    $schema[] = Grid::make(1 + count($vacuumLoads))->schema($gridFields);
                }

                return $schema;
            })
            ->action(function (array $data) use ($type, $vacuumLoads): void {
                DB::transaction(function () use ($data, $type, $vacuumLoads): void {
                    foreach ($data as $key => $value) {
                        if (str_starts_with($key, 'value_')) {
                            $parts      = explode('_', $key);
                            $diaId      = $parts[1];
                            $encodedKey = $parts[2];
                            $actualLoad = $vacuumLoads[$encodedKey]['value'] ?? null;

                            if (!$actualLoad) continue;

                            if ($value !== null && $value !== '') {
                                ThicknessVacuum::updateOrCreate(
                                    [
                                        'master_diameter_id' => $diaId,
                                        'vacuum_type'        => $type,
                                        'vacuum_load'        => $actualLoad,
                                    ],
                                    ['thickness' => $value]
                                );
                            } else {
                                ThicknessVacuum::where([
                                    'master_diameter_id' => $diaId,
                                    'vacuum_type'        => $type,
                                    'vacuum_load'        => $actualLoad,
                                ])->delete();
                            }
                        }
                    }
                });

                Notification::make()
                    ->title("Matrix $type berhasil disimpan")
                    ->success()
                    ->send();
            });
    }
}