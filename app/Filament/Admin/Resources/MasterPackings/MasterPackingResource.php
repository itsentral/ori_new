<?php

namespace App\Filament\Admin\Resources\MasterPackings;

use App\Filament\Admin\Resources\MasterPackings\Pages\CreateMasterPacking;
use App\Filament\Admin\Resources\MasterPackings\Pages\EditMasterPacking;
use App\Filament\Admin\Resources\MasterPackings\Pages\ListMasterPackings;
use App\Filament\Admin\Resources\MasterPackings\Pages\ViewMasterPacking;
use App\Filament\Admin\Resources\MasterPackings\Schemas\MasterPackingForm;
use App\Filament\Admin\Resources\MasterPackings\Schemas\MasterPackingInfolist;
use App\Filament\Admin\Resources\MasterPackings\Tables\MasterPackingsTable;
use App\Models\MasterPiece;
use BackedEnum;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\BaseResource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterPackingResource extends BaseResource
{
    protected static ?string $model = MasterPiece::class;

    protected static ?string $navigationLabel = 'Master Packing';
    protected static ?string $modelLabel = 'Master Packing';
    protected static ?string $pluralModelLabel = 'Master Packing';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'pieces_name';

    public static function form(Schema $schema): Schema
    {
        $recordId = $schema->getRecord()?->id ?? null;

        return MasterPackingForm::configure($schema, category: 2, recordId: $recordId);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MasterPackingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MasterPackingsTable::configure($table);
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
            'index' => ListMasterPackings::route('/'),
            'create' => CreateMasterPacking::route('/create'),
            'view' => ViewMasterPacking::route('/{record}'),
            'edit' => EditMasterPacking::route('/{record}/edit'),
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
        return parent::getEloquentQuery()->where('category_pieces', 2);
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Master Data';
    }

    public static function getNavigationLabel(): string
    {
        return 'Master Packing';
    }
}
