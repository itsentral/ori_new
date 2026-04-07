<?php

namespace App\Filament\Admin\Resources\MasterThicknessExternals;

use App\Filament\Admin\Resources\BaseResource;
use App\Filament\Admin\Resources\MasterThicknessExternals\Pages\CreateMasterThicknessExternal;
use App\Filament\Admin\Resources\MasterThicknessExternals\Pages\EditMasterThicknessExternal;
use App\Filament\Admin\Resources\MasterThicknessExternals\Pages\ListMasterThicknessExternals;
use App\Filament\Admin\Resources\MasterThicknessExternals\Pages\ViewMasterThicknessExternal;
use App\Filament\Admin\Resources\MasterThicknessExternals\Schemas\MasterThicknessExternalForm;
use App\Filament\Admin\Resources\MasterThicknessExternals\Schemas\MasterThicknessExternalInfolist;
use App\Filament\Admin\Resources\MasterThicknessExternals\Tables\MasterThicknessExternalsTable;
use App\Models\MasterThicknessExternal;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterThicknessExternalResource extends BaseResource
{
    protected static ?string $model = MasterThicknessExternal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'layer';

    public static function form(Schema $schema): Schema
    {
        return MasterThicknessExternalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MasterThicknessExternalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MasterThicknessExternalsTable::configure($table);
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
            'index' => ListMasterThicknessExternals::route('/'),
            'create' => CreateMasterThicknessExternal::route('/create'),
            'view' => ViewMasterThicknessExternal::route('/{record}'),
            'edit' => EditMasterThicknessExternal::route('/{record}/edit'),
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
        return 'Thickness External';
    }
}
