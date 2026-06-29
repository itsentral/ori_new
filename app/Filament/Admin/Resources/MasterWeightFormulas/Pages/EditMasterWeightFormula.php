<?php

namespace App\Filament\Admin\Resources\MasterWeightFormulas\Pages;

use App\Filament\Admin\Resources\MasterWeightFormulas\MasterWeightFormulaResource;
use App\Models\MasterWeightFormula;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;

class EditMasterWeightFormula extends Page
{
    protected string $view = 'filament.admin.resources.master-weight-formulas.pages.edit-master-weight-formula';
    protected static string $resource = MasterWeightFormulaResource::class;

    public MasterWeightFormula $record;

    // Header
    public string $formula_name = '';
    public string $formula_type = '';

    // Fitting params
    public array $fitting_params = [];

    // Waste pipe
    public array $waste_pipe = [];

    // Luas area
    public array $luas_area = [];

    // Setting FW
    public array $setting_fw = [];

    // Resin contain
    public array $resin_contain = [];

    // Glass weight
    public array $glass_weight = [];

    // Resin weight
    public array $resin_weight = [];

    // Additive
    public array $additive = [];

    // Mirror glaze
    public array $mirror_glaze = [];

    // Additional additive
    public array $additional_additive = [];

    // Total weight
    public array $total_weight = [];

    public function mount(MasterWeightFormula $record): void
    {
        $this->record = $record;
        $this->formula_name = $record->formula_name ?? '';
        $this->formula_type = $record->formula_type ?? '';
        $this->fitting_params = $record->fitting_params ?? [];
        $this->waste_pipe = $record->waste_pipe ?? [];
        $this->luas_area = $record->luas_area ?? [];
        $this->setting_fw = $record->setting_fw ?? [];
        $this->resin_contain = $record->resin_contain ?? [];
        $this->glass_weight = $record->glass_weight ?? [];
        $this->resin_weight = $record->resin_weight ?? [];
        $this->additive = $record->additive ?? [];
        $this->mirror_glaze = $record->mirror_glaze ?? [];
        $this->additional_additive = $record->additional_additive ?? [];
        $this->total_weight = $record->total_weight ?? [];
    }

    public function getTitle(): string
    {
        return "Edit Formula — {$this->record->formula_name}";
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-m-arrow-left')
                ->color('gray')
                ->url(MasterWeightFormulaResource::getUrl('view', ['record' => $this->record])),
            Action::make('save')
                ->label('Simpan')
                ->icon('heroicon-m-check')
                ->color('success')
                ->action('save'),
        ];
    }

    public function save(): void
    {
        $this->record->update([
            'formula_name'        => $this->formula_name,
            'formula_type'        => $this->formula_type,
            'fitting_params'      => !empty($this->fitting_params) ? $this->fitting_params : null,
            'waste_pipe'          => !empty($this->waste_pipe) ? $this->waste_pipe : null,
            'luas_area'           => !empty($this->luas_area) ? $this->luas_area : null,
            'setting_fw'          => !empty($this->setting_fw) ? $this->setting_fw : null,
            'resin_contain'       => !empty($this->resin_contain) ? $this->resin_contain : null,
            'glass_weight'        => !empty($this->glass_weight) ? $this->glass_weight : null,
            'resin_weight'        => !empty($this->resin_weight) ? $this->resin_weight : null,
            'additive'            => !empty($this->additive) ? $this->additive : null,
            'mirror_glaze'        => !empty($this->mirror_glaze) ? $this->mirror_glaze : null,
            'additional_additive' => !empty($this->additional_additive) ? $this->additional_additive : null,
            'total_weight'        => !empty($this->total_weight) ? $this->total_weight : null,
        ]);

        Notification::make()
            ->title('Formula berhasil disimpan!')
            ->success()
            ->send();

        $this->redirect(MasterWeightFormulaResource::getUrl('view', ['record' => $this->record]));
    }
}
