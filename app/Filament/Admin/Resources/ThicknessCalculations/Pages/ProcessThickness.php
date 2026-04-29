<?php

namespace App\Filament\Admin\Resources\ThicknessCalculations\Pages;

use App\Filament\Admin\Resources\ThicknessCalculations\ThicknessCalculationResource;
use App\Models\MasterLayerThickness;
use App\Models\ThicknessCalculation;
use App\Models\ThicknessCalculationLayerSelection;
use App\Services\ThicknessCalculationService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;

class ProcessThickness extends Page
{
    protected string $view = 'filament.admin.resources.thickness-calculations.pages.process-thickness';
    protected static string $resource = ThicknessCalculationResource::class;

    public ThicknessCalculation $record;
    public array $selections = [];
    public bool $isRecalculating = true;
    public bool $isViewMode = false;

    // public function mount(ThicknessCalculation $record): void
    // {
    //     $this->record = $record;
    //     $this->isViewMode = $record->layer_selection_status === 'selected';

    //     if ($this->isViewMode) {
    //         $this->isRecalculating = false;
    //         foreach ($record->details as $detail) {
    //             $this->selections[$detail->id] = $detail->selected_thickness_id
    //                 ? (string) $detail->selected_thickness_id
    //                 : null;
    //         }
    //     }
    // }

    public function mount(ThicknessCalculation $record): void
    {
        $this->record = $record;
        $this->isViewMode = false; // selalu bisa edit

        // Tetap load selections yang sudah ada jika ada
        foreach ($record->details as $detail) {
            $this->selections[$detail->id] = $detail->selected_thickness_id
                ? (string) $detail->selected_thickness_id
                : null;
        }
    }

    public function booted(): void
    {
        // Pastikan record selalu fresh
        $this->record->refresh();
    }

    public function getTitle(): string
    {
        return "Proses Thickness — {$this->record->calculation_code}";
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Action::make('back')
    //             ->label('Kembali')
    //             ->icon('heroicon-m-arrow-left')
    //             ->color('gray')
    //             ->url(ThicknessCalculationResource::getUrl('index')),

    //         Action::make('recalculate')
    //             ->label('Hitung Ulang')
    //             ->icon('heroicon-m-arrow-path')
    //             ->color('warning')
    //             ->hidden(fn() => $this->isRecalculating || $this->isViewMode)
    //             ->action('recalculate'),

    //         Action::make('save')
    //             ->label('Simpan Pilihan')
    //             ->icon('heroicon-m-check')
    //             ->color('success')
    //             ->hidden(fn() => $this->isRecalculating || $this->isViewMode)
    //             ->action('saveSelections'),
    //     ];
    // }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-m-arrow-left')
                ->color('gray')
                ->url(ThicknessCalculationResource::getUrl('index')),

            Action::make('recalculate')
                ->label('Hitung Ulang')
                ->icon('heroicon-m-arrow-path')
                ->color('warning')
                ->hidden(fn() => $this->isRecalculating) // hapus || $this->isViewMode
                ->action('recalculate'),

            Action::make('save')
                ->label('Simpan Pilihan')
                ->icon('heroicon-m-check')
                ->color('success')
                ->hidden(fn() => $this->isRecalculating) // hapus || $this->isViewMode
                ->action('saveSelections'),
        ];
    }

    // Dipanggil dari JS saat halaman sudah mount (via wire:init)
    public function recalculate(): void
    {
        $this->isRecalculating = true;

        $service = new ThicknessCalculationService();
        $record  = $this->record;

        $details = $service->generateDetails([
            'liner_id'            => $record->liner_id,
            'liner_thickness'     => $record->liner_thickness_snapshot,
            'pressure_nominal_id' => $record->pressure_nominal_id,
            'temperature'         => $record->temperature,
            'vacuum_type'         => $record->vacuum_type,
            'vacuum_load'         => $record->vacuum_load_snapshot,
            'stiffness'           => $record->stiffness_snapshot,
            'use_external'        => $record->use_external,
            'external_thickness'  => $record->external_thickness_snapshot,
            'use_top_coat'        => $record->use_top_coat,
        ]);

        if (!empty($record->layer_category)) {
            $details = $service->matchLayerForDetails($details, $record->layer_category);
        }

        // Update atau create per diameter — jangan delete semua
        foreach ($details as $detailData) {
            $record->details()->updateOrCreate(
                ['diameter_id' => $detailData['diameter_id']],
                $detailData
            );
        }

        $record->refresh();

        // Load selections dari DB
        $this->selections = [];
        foreach ($record->details as $detail) {
            $this->selections[$detail->id] = $detail->selected_thickness_id
                ? (string) $detail->selected_thickness_id
                : null;
        }

        $this->isRecalculating = false;
    }

    // public function saveSelections(): void
    // {
    //     $details = $this->record->details()->whereNotNull('matched_layer_id')->get();

    //     // Validasi
    //     foreach ($details as $detail) {
    //         if (empty($this->selections[$detail->id])) {
    //             Notification::make()
    //                 ->title('Ada thickness yang belum dipilih!')
    //                 ->body("DN {$detail->diameter_inch_snapshot} ({$detail->diameter_mm_snapshot} mm) belum dipilih.")
    //                 ->danger()
    //                 ->send();
    //             return;
    //         }
    //     }

    //     foreach ($details as $detail) {
    //         $selectedId = $this->selections[$detail->id] ?? null;
    //         if (!$selectedId) continue;

    //         $thickness = MasterLayerThickness::find($selectedId);

    //         $updated = $detail->update([
    //             'selected_thickness_id'    => (int) $selectedId,
    //             'selected_thickness_value' => $thickness?->thickness,
    //         ]);

    //         ThicknessCalculationLayerSelection::updateOrCreate(
    //             [
    //                 'calculation_id' => $this->record->id,
    //                 'detail_id'      => $detail->id,
    //             ],
    //             [
    //                 'diameter_inch_snapshot'   => $detail->diameter_inch_snapshot,
    //                 'diameter_mm_snapshot'     => $detail->diameter_mm_snapshot,
    //                 'layer_id'                 => $detail->matched_layer_id,
    //                 'layer_code_snapshot'      => $detail->matched_layer_code_snapshot,
    //                 'layer_category_snapshot'  => $this->record->layer_category,
    //                 'layer_thickness_id'       => (int) $selectedId,
    //                 'thickness_value_snapshot' => $thickness?->thickness,
    //                 'selected_by'              => auth()->id(),
    //             ]
    //         );
    //     }

    //     $this->record->update(['layer_selection_status' => 'selected']);

    //     Notification::make()
    //         ->title('Berhasil disimpan!')
    //         ->success()
    //         ->send();

    //     $this->redirect(ThicknessCalculationResource::getUrl('index'));
    // }

    public function saveSelections(): void
    {
        $details = $this->record->details()->whereNotNull('matched_layer_id')->get();

        // foreach ($details as $detail) {
        //     if (empty($this->selections[$detail->id])) {
        //         Notification::make()
        //             ->title('Ada thickness yang belum dipilih!')
        //             ->body("DN {$detail->diameter_inch_snapshot} ({$detail->diameter_mm_snapshot} mm) belum dipilih.")
        //             ->danger()
        //             ->send();
        //         return;
        //     }
        // }

        foreach ($details as $detail) {
            $selectedId = $this->selections[$detail->id] ?? null;
            if (!$selectedId) continue;

            $thickness = MasterLayerThickness::find($selectedId);

            $detail->update([
                'selected_thickness_id'    => (int) $selectedId,
                'selected_thickness_value' => $thickness?->thickness,
            ]);

            ThicknessCalculationLayerSelection::updateOrCreate(
                [
                    'calculation_id' => $this->record->id,
                    'detail_id'      => $detail->id,
                ],
                [
                    'diameter_inch_snapshot'   => $detail->diameter_inch_snapshot,
                    'diameter_mm_snapshot'     => $detail->diameter_mm_snapshot,
                    'layer_id'                 => $detail->matched_layer_id,
                    'layer_code_snapshot'      => $detail->matched_layer_code_snapshot,
                    'layer_category_snapshot'  => $this->record->layer_category,
                    'layer_thickness_id'       => (int) $selectedId,
                    'thickness_value_snapshot' => $thickness?->thickness,
                    'selected_by'              => auth()->id(),
                ]
            );
        }

        // Hapus baris ini — jangan update status
        // $this->record->update(['layer_selection_status' => 'selected']);

        Notification::make()
            ->title('Berhasil disimpan!')
            ->success()
            ->send();

        $this->redirect(ThicknessCalculationResource::getUrl('index'));
    }

    public ?int $selectedDetailId = null;
    public bool $showLayerModal = false;

    public function viewLayerDetail(int $detailId): void
    {
        $this->selectedDetailId = $detailId;
        $this->showLayerModal = true;
    }

    public function closeLayerModal(): void
    {
        $this->showLayerModal = false;
        $this->selectedDetailId = null;
    }

    public function getSelectedDetail()
    {
        if (!$this->selectedDetailId) return null;
        return $this->record->details()->find($this->selectedDetailId);
    }

    public function getSelectedLayer()
    {
        $detail = $this->getSelectedDetail();
        if (!$detail?->matched_layer_id) return null;
        return \App\Models\MasterLayer::with('thicknesses.details.materialType')->find($detail->matched_layer_id);
    }
}
