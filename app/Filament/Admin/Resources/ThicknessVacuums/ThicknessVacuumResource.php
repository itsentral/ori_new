<?php

namespace App\Filament\Admin\Resources\ThicknessVacuums;

use App\Filament\Admin\Resources\BaseResource;
use App\Filament\Admin\Resources\ThicknessVacuums\Pages\CreateThicknessVacuum;
use App\Filament\Admin\Resources\ThicknessVacuums\Pages\EditThicknessVacuum;
use App\Filament\Admin\Resources\ThicknessVacuums\Pages\ListThicknessVacuums;
use App\Filament\Admin\Resources\ThicknessVacuums\Pages\ViewThicknessVacuum;
use App\Filament\Admin\Resources\ThicknessVacuums\Schemas\ThicknessVacuumForm;
use App\Filament\Admin\Resources\ThicknessVacuums\Schemas\ThicknessVacuumInfolist;
use App\Filament\Admin\Resources\ThicknessVacuums\Tables\ThicknessVacuumsTable;
use App\Models\ThicknessVacuum;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ThicknessVacuumResource extends BaseResource
{
    protected static ?string $model = ThicknessVacuum::class;

    protected static ?int $navigationSort = 7;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'vacuum_type';

    public static function form(Schema $schema): Schema
    {
        return ThicknessVacuumForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ThicknessVacuumInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ThicknessVacuumsTable::configure($table);
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
            'index' => ListThicknessVacuums::route('/'),
            'create' => CreateThicknessVacuum::route('/create'),
            'view' => ViewThicknessVacuum::route('/{record}'),
            'edit' => EditThicknessVacuum::route('/{record}/edit'),
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
        return 'Thickness Vacuum';
    }
}
