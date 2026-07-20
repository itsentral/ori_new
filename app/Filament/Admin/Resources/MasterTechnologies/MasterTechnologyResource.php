<?php

namespace App\Filament\Admin\Resources\MasterTechnologies;

use App\Filament\Admin\Resources\MasterTechnologies\Pages\CreateMasterTechnology;
use App\Filament\Admin\Resources\MasterTechnologies\Pages\EditMasterTechnology;
use App\Filament\Admin\Resources\MasterTechnologies\Pages\ListMasterTechnologies;
use App\Filament\Admin\Resources\MasterTechnologies\Schemas\MasterTechnologyForm;
use App\Filament\Admin\Resources\MasterTechnologies\Tables\MasterTechnologiesTable;
use App\Models\MasterTechnology;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterTechnologyResource extends Resource
{
    protected static ?string $model = MasterTechnology::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MasterTechnologyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MasterTechnologiesTable::configure($table);
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
            'index' => ListMasterTechnologies::route('/'),
            'create' => CreateMasterTechnology::route('/create'),
            'edit' => EditMasterTechnology::route('/{record}/edit'),
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
        return 'Master Data';
    }

    public static function getNavigationLabel(): string
    {
        return 'Master Technologies';
    }
}
