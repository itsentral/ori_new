<?php

namespace App\Filament\Admin\Resources\MasterApplications;

use App\Filament\Admin\Resources\BaseResource;
use App\Filament\Admin\Resources\MasterApplications\Pages\CreateMasterApplication;
use App\Filament\Admin\Resources\MasterApplications\Pages\EditMasterApplication;
use App\Filament\Admin\Resources\MasterApplications\Pages\ListMasterApplications;
use App\Filament\Admin\Resources\MasterApplications\Pages\ViewMasterApplication;
use App\Filament\Admin\Resources\MasterApplications\Schemas\MasterApplicationForm;
use App\Filament\Admin\Resources\MasterApplications\Schemas\MasterApplicationInfolist;
use App\Filament\Admin\Resources\MasterApplications\Tables\MasterApplicationsTable;
use App\Models\MasterApplication;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterApplicationResource extends BaseResource
{
    protected static ?string $model = MasterApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'application_name';

    public static function form(Schema $schema): Schema
    {
        return MasterApplicationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MasterApplicationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MasterApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListMasterApplications::route('/'),
            'create' => CreateMasterApplication::route('/create'),
            'view'   => ViewMasterApplication::route('/{record}'),
            'edit'   => EditMasterApplication::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Master Data';
    }

    public static function getNavigationLabel(): string
    {
        return 'Master Application';
    }
}