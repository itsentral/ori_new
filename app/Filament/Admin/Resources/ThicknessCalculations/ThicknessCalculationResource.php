<?php

namespace App\Filament\Admin\Resources\ThicknessCalculations;

use App\Filament\Admin\Resources\ThicknessCalculations\Pages\CreateThicknessCalculation;
use App\Filament\Admin\Resources\ThicknessCalculations\Pages\EditThicknessCalculation;
use App\Filament\Admin\Resources\ThicknessCalculations\Pages\ListThicknessCalculations;
use App\Filament\Admin\Resources\ThicknessCalculations\Pages\ViewThicknessCalculation;
use App\Filament\Admin\Resources\ThicknessCalculations\Schemas\ThicknessCalculationForm;
use App\Filament\Admin\Resources\ThicknessCalculations\Schemas\ThicknessCalculationInfolist;
use App\Filament\Admin\Resources\ThicknessCalculations\Tables\ThicknessCalculationsTable;
use App\Models\ThicknessCalculation;
use BackedEnum;
use App\Filament\Admin\Resources\BaseResource;
use App\Filament\Admin\Resources\ThicknessCalculations\Pages\ProcessThickness;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ThicknessCalculationResource extends BaseResource
{
    protected static ?string $model = ThicknessCalculation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'brand_name';

    public static function form(Schema $schema): Schema
    {
        return ThicknessCalculationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ThicknessCalculationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ThicknessCalculationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListThicknessCalculations::route('/'),
            'create' => CreateThicknessCalculation::route('/create'),
            'view' => ViewThicknessCalculation::route('/{record}'),
            'edit' => EditThicknessCalculation::route('/{record}/edit'),
            'process-thickness' => ProcessThickness::route('/{record}/process-thickness'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Developing Product';
    }

    public static function getNavigationLabel(): string
    {
        return 'Calculation';
    }
}
