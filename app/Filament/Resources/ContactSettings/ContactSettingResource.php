<?php

namespace App\Filament\Resources\ContactSettings;

use App\Filament\Resources\ContactSettings\Pages\CreateContactSetting;
use App\Filament\Resources\ContactSettings\Pages\EditContactSetting;
use App\Filament\Resources\ContactSettings\Pages\ListContactSettings;
use App\Filament\Resources\ContactSettings\Pages\ViewContactSetting;
use App\Filament\Resources\ContactSettings\Schemas\ContactSettingForm;
use App\Filament\Resources\ContactSettings\Schemas\ContactSettingInfolist;
use App\Filament\Resources\ContactSettings\Tables\ContactSettingsTable;
use App\Models\ContactSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContactSettingResource extends Resource
{
    protected static ?string $model = ContactSetting::class;

    protected static ?string $navigationLabel = 'Contact Settings';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    public static function getNavigationGroup(): ?string
    {
        return 'Contact & Social';
    }

    public static function form(Schema $schema): Schema
    {
        return ContactSettingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContactSettingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactSettingsTable::configure($table);
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
            'index' => ListContactSettings::route('/'),
            'create' => CreateContactSetting::route('/create'),
            'view' => ViewContactSetting::route('/{record}'),
            'edit' => EditContactSetting::route('/{record}/edit'),
        ];
    }
}
