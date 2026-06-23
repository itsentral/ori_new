<?php

namespace App\Filament\Admin\Resources\MasterLayers;

use App\Filament\Admin\Resources\BaseResource;
use App\Filament\Admin\Resources\MasterLayers\Pages\CreateMasterLayer;
use App\Filament\Admin\Resources\MasterLayers\Pages\EditMasterLayer;
use App\Filament\Admin\Resources\MasterLayers\Pages\ListMasterLayers;
use App\Filament\Admin\Resources\MasterLayers\Pages\ViewMasterLayer;
use App\Filament\Admin\Resources\MasterLayers\Schemas\MasterLayerForm;
use App\Filament\Admin\Resources\MasterLayers\Schemas\MasterLayerInfolist;
use App\Filament\Admin\Resources\MasterLayers\Tables\MasterLayersTable;
use App\Models\MasterLayer;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterLayerResource extends BaseResource
{
    protected static ?string $model = MasterLayer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'layer_code';

    public static function form(Schema $schema): Schema
    {
        return MasterLayerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MasterLayerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MasterLayersTable::configure($table);
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
            'index' => ListMasterLayers::route('/'),
            'create' => CreateMasterLayer::route('/create'),
            'view' => ViewMasterLayer::route('/{record}'),
            'edit' => EditMasterLayer::route('/{record}/edit'),
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
        return 'Master Layer Structure';
    }
}
