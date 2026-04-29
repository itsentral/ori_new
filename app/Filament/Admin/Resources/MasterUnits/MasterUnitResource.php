<?php

namespace App\Filament\Admin\Resources\MasterUnits;

use App\Filament\Admin\Resources\MasterUnits\Pages\CreateMasterUnit;
use App\Filament\Admin\Resources\MasterUnits\Pages\EditMasterUnit;
use App\Filament\Admin\Resources\MasterUnits\Pages\ListMasterUnits;
use App\Filament\Admin\Resources\MasterUnits\Schemas\MasterUnitForm;
use App\Filament\Admin\Resources\MasterUnits\Tables\MasterUnitsTable;
use App\Models\MasterPiece;
use BackedEnum;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\BaseResource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterUnitResource extends BaseResource
{
    protected static ?string $model = MasterPiece::class;

    protected static ?string $navigationLabel = 'Master Unit';
    protected static ?string $modelLabel = 'Master Unit';
    protected static ?string $pluralModelLabel = 'Master Unit';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        $recordId = $schema->getRecord()?->id ?? null;

        return MasterUnitForm::configure($schema, category: 1, recordId: $recordId);
    }

    public static function table(Table $table): Table
    {
        return MasterUnitsTable::configure($table);
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
            'index' => ListMasterUnits::route('/'),
            'create' => CreateMasterUnit::route('/create'),
            'edit' => EditMasterUnit::route('/{record}/edit'),
            'view' => Pages\ViewMasterUnit::route('/{record}'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('category_pieces', 1);
    }

     public static function getNavigationGroup(): ?string
    {
        return 'Master Data';
    }

    public static function getNavigationLabel(): string
    {
        return 'Master Unit';
    }
}
