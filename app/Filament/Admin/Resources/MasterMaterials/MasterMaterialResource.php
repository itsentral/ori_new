<?php

namespace App\Filament\Admin\Resources\MasterMaterials;

use App\Filament\Admin\Resources\MasterMaterials\Pages\CreateMasterMaterial;
use App\Filament\Admin\Resources\MasterMaterials\Pages\EditMasterMaterial;
use App\Filament\Admin\Resources\MasterMaterials\Pages\ListMasterMaterials;
use App\Filament\Admin\Resources\MasterMaterials\Pages\ViewMasterMaterial;
use App\Filament\Admin\Resources\MasterMaterials\Schemas\MasterMaterialForm;
use App\Filament\Admin\Resources\MasterMaterials\Schemas\MasterMaterialInfolist;
use App\Filament\Admin\Resources\MasterMaterials\Tables\MasterMaterialsTable;
use App\Models\MasterMaterial;
use BackedEnum;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\BaseResource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterMaterialResource extends BaseResource
{
    protected static ?string $model = MasterMaterial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'material_name';

    public static function form(Schema $schema): Schema
    {
        return MasterMaterialForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MasterMaterialInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MasterMaterialsTable::configure($table);
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
            'index' => ListMasterMaterials::route('/'),
            'create' => CreateMasterMaterial::route('/create'),
            'view' => ViewMasterMaterial::route('/{record}'),
            'edit' => EditMasterMaterial::route('/{record}/edit'),
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
        return 'Master Material';
    }
}
