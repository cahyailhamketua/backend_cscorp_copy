<?php

namespace App\Filament\Resources\ContactSettings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContactSettingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('email_receiver')
                    ->label('Email Penerima')
                    ->icon('heroicon-o-envelope'),
                TextEntry::make('created_at')
                    ->label('Dibuat')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime(),
            ]);
    }
}
