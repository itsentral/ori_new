<?php

namespace App\Filament\Admin\Resources\ThicknessPressureTemps;

use App\Filament\Admin\Resources\BaseResource;
use App\Filament\Admin\Resources\ThicknessPressureTemps\Pages\CreateThicknessPressureTemp;
use App\Filament\Admin\Resources\ThicknessPressureTemps\Pages\EditThicknessPressureTemp;
use App\Filament\Admin\Resources\ThicknessPressureTemps\Pages\ListThicknessPressureTemps;
use App\Filament\Admin\Resources\ThicknessPressureTemps\Pages\ViewThicknessPressureTemp;
use App\Filament\Admin\Resources\ThicknessPressureTemps\Schemas\ThicknessPressureTempForm;
use App\Filament\Admin\Resources\ThicknessPressureTemps\Schemas\ThicknessPressureTempInfolist;
use App\Filament\Admin\Resources\ThicknessPressureTemps\Tables\ThicknessPressureTempsTable;
use App\Models\ThicknessPressureTemp;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ThicknessPressureTempResource extends BaseResource
{
    protected static ?string $model = ThicknessPressureTemp::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'temperature';

    public static function form(Schema $schema): Schema
    {
        return ThicknessPressureTempForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ThicknessPressureTempInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ThicknessPressureTempsTable::configure($table);
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
            'index' => ListThicknessPressureTemps::route('/'),
            'create' => CreateThicknessPressureTemp::route('/create'),
            'view' => ViewThicknessPressureTemp::route('/{record}'),
            'edit' => EditThicknessPressureTemp::route('/{record}/edit'),
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
        return 'Thickness Pressure & Temp';
    }
}
