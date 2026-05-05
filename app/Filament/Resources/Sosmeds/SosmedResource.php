<?php

namespace App\Filament\Resources\Sosmeds;

use App\Filament\Resources\Sosmeds\Pages\CreateSosmed;
use App\Filament\Resources\Sosmeds\Pages\EditSosmed;
use App\Filament\Resources\Sosmeds\Pages\ListSosmeds;
use App\Filament\Resources\Sosmeds\Schemas\SosmedForm;
use App\Filament\Resources\Sosmeds\Tables\SosmedsTable;
use App\Models\Sosmed;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SosmedResource extends Resource
{
    protected static ?string $model = Sosmed::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return SosmedForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SosmedsTable::configure($table);
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
            'index' => ListSosmeds::route('/'),
            'create' => CreateSosmed::route('/create'),
            'edit' => EditSosmed::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Contact & Social';
    }
}
