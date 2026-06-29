<?php

namespace App\Filament\Admin\Resources\MasterWeightFormulas\Pages;

use App\Filament\Admin\Resources\MasterWeightFormulas\MasterWeightFormulaResource;
use App\Models\MasterWeightFormula;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;

class ViewMasterWeightFormula extends Page
{
    protected string $view = 'filament.admin.resources.master-weight-formulas.pages.view-master-weight-formula';
    protected static string $resource = MasterWeightFormulaResource::class;

    public MasterWeightFormula $record;

    public function mount(MasterWeightFormula $record): void
    {
        $this->record = $record;
    }

    public function getTitle(): string
    {
        return "Formula: {$this->record->formula_name}";
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-m-arrow-left')
                ->color('gray')
                ->url(MasterWeightFormulaResource::getUrl('index')),
            Action::make('edit')
                ->label('Edit Formula')
                ->icon('heroicon-m-pencil-square')
                ->color('warning')
                ->visible(fn() => auth()->user()?->hasRole('super_admin'))
                ->url(fn() => MasterWeightFormulaResource::getUrl('edit', ['record' => $this->record])),
        ];
    }
}
