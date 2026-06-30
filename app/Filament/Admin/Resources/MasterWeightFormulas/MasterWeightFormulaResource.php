<?php

namespace App\Filament\Admin\Resources\MasterWeightFormulas;

use App\Filament\Admin\Resources\BaseResource;
use App\Filament\Admin\Resources\MasterWeightFormulas\Pages\EditMasterWeightFormula;
use App\Filament\Admin\Resources\MasterWeightFormulas\Pages\ListMasterWeightFormulas;
use App\Filament\Admin\Resources\MasterWeightFormulas\Pages\ViewMasterWeightFormula;
use App\Models\MasterWeightFormula;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;

class MasterWeightFormulaResource extends BaseResource
{
    protected static ?string $model = MasterWeightFormula::class;

    protected static ?int $navigationSort = 10;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalculator;

    protected static ?string $recordTitleAttribute = 'formula_name';

    protected static function getPermissionName(): string
    {
        return 'master_weight_formula';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('formula_code')
                    ->label('Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('formula_name')
                    ->label('Formula Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('formula_type')
                    ->label('Tipe Formula')
                    ->badge()
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->color(fn($state) => match ($state) {
                        'pipe' => 'success',
                        'fitting' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn($record) => static::getUrl('view', ['record' => $record])),
                Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->visible(fn() => auth()->user()?->hasRole('super_admin'))
                    ->url(fn($record) => static::getUrl('edit', ['record' => $record])),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMasterWeightFormulas::route('/'),
            'view'  => ViewMasterWeightFormula::route('/{record}'),
            'edit'  => EditMasterWeightFormula::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Master Data';
    }

    public static function getNavigationLabel(): string
    {
        return 'Master Weight Formula';
    }

    public static function getModelLabel(): string
    {
        return 'Weight Formula';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Master Weight Formula';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}
