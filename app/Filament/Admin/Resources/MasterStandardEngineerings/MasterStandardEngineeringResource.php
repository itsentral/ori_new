<?php

namespace App\Filament\Admin\Resources\MasterStandardEngineerings;

use App\Filament\Admin\Resources\MasterStandardEngineerings\Pages\CreateMasterStandardEngineering;
use App\Filament\Admin\Resources\MasterStandardEngineerings\Pages\EditMasterStandardEngineering;
use App\Filament\Admin\Resources\MasterStandardEngineerings\Pages\ListMasterStandardEngineerings;
use App\Filament\Admin\Resources\MasterStandardEngineerings\Pages\ViewMasterStandardEngineering;
use App\Filament\Admin\Resources\MasterStandardEngineerings\Schemas\MasterStandardEngineeringForm;
use App\Filament\Admin\Resources\MasterStandardEngineerings\Schemas\MasterStandardEngineeringInfolist;
use App\Filament\Admin\Resources\MasterStandardEngineerings\Tables\MasterStandardEngineeringsTable;
use App\Models\MasterStandardEngineering;
use BackedEnum;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\BaseResource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MasterStandardEngineeringResource extends BaseResource
{
    protected static ?string $model = MasterStandardEngineering::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'engineering_name';



    public static function form(Schema $schema): Schema
    {
        return MasterStandardEngineeringForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MasterStandardEngineeringInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MasterStandardEngineeringsTable::configure($table);
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
            'index' => ListMasterStandardEngineerings::route('/'),
            'create' => CreateMasterStandardEngineering::route('/create'),
            'view' => ViewMasterStandardEngineering::route('/{record}'),
            'edit' => EditMasterStandardEngineering::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Master Data';
    }

    public static function getNavigationLabel(): string
    {
        return 'Master Standard Engineering';
    }

    public static function getRecordActions(): array
    {
        $model = static::getModel();

        $permissionName = \Illuminate\Support\Str::snake(class_basename($model));

        return [
            \Filament\Actions\ViewAction::make()
                ->visible(fn() => auth()->user()->can("view {$permissionName}")),

            \Filament\Actions\EditAction::make()
                ->visible(fn() => auth()->user()->can("update {$permissionName}")),
        ];
    }
}
