<?php

namespace App\Filament\Admin\Resources\MasterDiameters;

use App\Filament\Admin\Resources\MasterDiameters\Pages\CreateMasterDiameter;
use App\Filament\Admin\Resources\MasterDiameters\Pages\EditMasterDiameter;
use App\Filament\Admin\Resources\MasterDiameters\Pages\ListMasterDiameters;
use App\Filament\Admin\Resources\MasterDiameters\Pages\ViewMasterDiameter;
use App\Filament\Admin\Resources\MasterDiameters\Schemas\MasterDiameterForm;
use App\Filament\Admin\Resources\MasterDiameters\Schemas\MasterDiameterInfolist;
use App\Filament\Admin\Resources\MasterDiameters\Tables\MasterDiametersTable;
use App\Models\MasterDiameter;
use BackedEnum;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\BaseResource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MasterDiameterResource extends BaseResource
{
    protected static ?string $model = MasterDiameter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'diameter_mm';

    public static function form(Schema $schema): Schema
    {
        return MasterDiameterForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MasterDiameterInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MasterDiametersTable::configure($table);
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
            'index' => ListMasterDiameters::route('/'),
            'create' => CreateMasterDiameter::route('/create'),
            'view' => ViewMasterDiameter::route('/{record}'),
            'edit' => EditMasterDiameter::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Developing Product';
    }

    public static function getNavigationLabel(): string
    {
        return 'Master Diameter';
    }
}
