<?php

namespace App\Filament\Admin\Resources\MasterTopCoats\Pages;

use App\Filament\Admin\Resources\MasterTopCoats\MasterTopCoatResource;
use App\Models\MasterDiameter;
use App\Models\MasterTopCoat;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class ListMasterTopCoats extends ListRecords
{
    protected static string $resource = MasterTopCoatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->getMatrixAction(),
        ];
    }

    protected function getMatrixAction(): Action
    {
        return Action::make('inputMatrix')
            ->label('Input Matrix Top Coat')
            ->color('success')
            ->icon('heroicon-o-table-cells')
            ->modalHeading('Input Matrix Top Coat')
            ->modalWidth('3xl')
            ->closeModalByClickingAway(false)
            ->fillForm(function (): array {
                $existingData = MasterTopCoat::all();

                $formData = [];
                foreach ($existingData as $record) {
                    $formData["value_{$record->diameter_id}"] = $record->thickness;
                }

                return $formData;
            })
            ->schema(function (): array {
                $diameters = MasterDiameter::orderBy('diameter_mm')->get();

                $schema = [];
                foreach ($diameters as $dia) {
                    $schema[] = Grid::make(2)
                        ->schema([
                            TextInput::make("dia_{$dia->id}_label")
                                ->label('Diameter')
                                ->afterStateHydrated(fn($component) => $component->state($dia->diameter_mm . ' mm'))
                                ->disabled()
                                ->dehydrated(false),

                            TextInput::make("value_{$dia->id}")
                                ->label('Thickness')
                                ->numeric()
                                ->placeholder('mm'),
                        ]);
                }

                return $schema;
            })
            ->action(function (array $data): void {
                DB::transaction(function () use ($data): void {
                    foreach ($data as $key => $value) {
                        if (str_starts_with($key, 'value_')) {
                            $diaId = explode('_', $key)[1];

                            if ($value !== null && $value !== '') {
                                MasterTopCoat::updateOrCreate(
                                    ['diameter_id' => $diaId],
                                    ['thickness'   => $value]
                                );
                            } else {
                                MasterTopCoat::where('diameter_id', $diaId)->delete();
                            }
                        }
                    }
                });

                Notification::make()
                    ->title('Matrix Top Coat berhasil disimpan')
                    ->success()
                    ->send();
            });
    }
}
