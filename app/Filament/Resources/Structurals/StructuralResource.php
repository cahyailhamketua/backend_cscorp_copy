<?php

namespace App\Filament\Resources\Structurals;

use App\Filament\Resources\Structurals\Pages\CreateStructural;
use App\Filament\Resources\Structurals\Pages\EditStructural;
use App\Filament\Resources\Structurals\Pages\ListStructurals;
use App\Filament\Resources\Structurals\Schemas\StructuralForm;
use App\Filament\Resources\Structurals\Tables\StructuralsTable;
use App\Models\Structural;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StructuralResource extends Resource
{
    protected static ?string $model = Structural::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return StructuralForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StructuralsTable::configure($table);
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
            'index' => ListStructurals::route('/'),
            'create' => CreateStructural::route('/create'),
            'edit' => EditStructural::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'About';
    }
}
