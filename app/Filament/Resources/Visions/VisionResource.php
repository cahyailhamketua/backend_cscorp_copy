<?php

namespace App\Filament\Resources\Visions;

use App\Filament\Resources\Visions\Pages\CreateVision;
use App\Filament\Resources\Visions\Pages\EditVision;
use App\Filament\Resources\Visions\Pages\ListVisions;
use App\Filament\Resources\Visions\Schemas\VisionForm;
use App\Filament\Resources\Visions\Tables\VisionsTable;
use App\Models\Vision;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VisionResource extends Resource
{
    protected static ?string $model = Vision::class;

    protected static ?string $modelLabel = 'Visi & Misi';
    protected static ?string $pluralModelLabel = 'Visi & Misi';

    protected static ?string $navigationLabel = 'Visi & Misi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return VisionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VisionsTable::configure($table);
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
            'index' => ListVisions::route('/'),
            'create' => CreateVision::route('/create'),
            'edit' => EditVision::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'About';
    }
}
