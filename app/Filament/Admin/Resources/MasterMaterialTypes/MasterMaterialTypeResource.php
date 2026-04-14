<?php

namespace App\Filament\Admin\Resources\MasterMaterialTypes;

use App\Filament\Admin\Resources\MasterMaterialTypes\Pages\CreateMasterMaterialType;
use App\Filament\Admin\Resources\MasterMaterialTypes\Pages\EditMasterMaterialType;
use App\Filament\Admin\Resources\MasterMaterialTypes\Pages\ListMasterMaterialTypes;
use App\Filament\Admin\Resources\MasterMaterialTypes\Pages\ViewMasterMaterialType;
use App\Filament\Admin\Resources\MasterMaterialTypes\Schemas\MasterMaterialTypeForm;
use App\Filament\Admin\Resources\MasterMaterialTypes\Schemas\MasterMaterialTypeInfolist;
use App\Filament\Admin\Resources\MasterMaterialTypes\Tables\MasterMaterialTypesTable;
use App\Models\MasterMaterialType;
use BackedEnum;
use App\Filament\Admin\Resources\BaseResource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterMaterialTypeResource extends BaseResource
{
    protected static ?string $model = MasterMaterialType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'type_name';

    public static function form(Schema $schema): Schema
    {
        return MasterMaterialTypeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MasterMaterialTypeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MasterMaterialTypesTable::configure($table);
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
            'index' => ListMasterMaterialTypes::route('/'),
            'create' => CreateMasterMaterialType::route('/create'),
            'view' => ViewMasterMaterialType::route('/{record}'),
            'edit' => EditMasterMaterialType::route('/{record}/edit'),
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
        return 'Master Inventory';
    }

    public static function getNavigationLabel(): string
    {
        return 'Master Material Type';
    }
}
