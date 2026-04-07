<?php

namespace App\Filament\Admin\Resources\MasterPressureNominals;

use App\Filament\Admin\Resources\BaseResource;
use App\Filament\Admin\Resources\MasterPressureNominals\Pages\CreateMasterPressureNominal;
use App\Filament\Admin\Resources\MasterPressureNominals\Pages\EditMasterPressureNominal;
use App\Filament\Admin\Resources\MasterPressureNominals\Pages\ListMasterPressureNominals;
use App\Filament\Admin\Resources\MasterPressureNominals\Pages\ViewMasterPressureNominal;
use App\Filament\Admin\Resources\MasterPressureNominals\Schemas\MasterPressureNominalForm;
use App\Filament\Admin\Resources\MasterPressureNominals\Schemas\MasterPressureNominalInfolist;
use App\Filament\Admin\Resources\MasterPressureNominals\Tables\MasterPressureNominalsTable;
use App\Models\MasterPressureNominal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MasterPressureNominalResource extends BaseResource
{
    protected static ?string $model = MasterPressureNominal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'pn_name';

    public static function form(Schema $schema): Schema
    {
        return MasterPressureNominalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MasterPressureNominalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MasterPressureNominalsTable::configure($table);
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
            'index' => ListMasterPressureNominals::route('/'),
            'create' => CreateMasterPressureNominal::route('/create'),
            'view' => ViewMasterPressureNominal::route('/{record}'),
            'edit' => EditMasterPressureNominal::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Master Data';
    }

    public static function getNavigationLabel(): string
    {
        return 'Master Pressure Nominal';
    }
}
