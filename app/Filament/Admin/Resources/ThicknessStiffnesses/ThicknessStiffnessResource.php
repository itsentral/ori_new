<?php

namespace App\Filament\Admin\Resources\ThicknessStiffnesses;

use App\Filament\Admin\Resources\BaseResource;
use App\Filament\Admin\Resources\ThicknessStiffnesses\Pages\CreateThicknessStiffness;
use App\Filament\Admin\Resources\ThicknessStiffnesses\Pages\EditThicknessStiffness;
use App\Filament\Admin\Resources\ThicknessStiffnesses\Pages\ListThicknessStiffnesses;
use App\Filament\Admin\Resources\ThicknessStiffnesses\Pages\ViewThicknessStiffness;
use App\Filament\Admin\Resources\ThicknessStiffnesses\Schemas\ThicknessStiffnessForm;
use App\Filament\Admin\Resources\ThicknessStiffnesses\Schemas\ThicknessStiffnessInfolist;
use App\Filament\Admin\Resources\ThicknessStiffnesses\Tables\ThicknessStiffnessesTable;
use App\Models\ThicknessStiffness;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ThicknessStiffnessResource extends BaseResource
{
    protected static ?string $model = ThicknessStiffness::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'stiffness';

    public static function form(Schema $schema): Schema
    {
        return ThicknessStiffnessForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ThicknessStiffnessInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ThicknessStiffnessesTable::configure($table);
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
            'index' => ListThicknessStiffnesses::route('/'),
            'create' => CreateThicknessStiffness::route('/create'),
            'view' => ViewThicknessStiffness::route('/{record}'),
            'edit' => EditThicknessStiffness::route('/{record}/edit'),
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
        return 'Thickness Stiffness';
    }
}
