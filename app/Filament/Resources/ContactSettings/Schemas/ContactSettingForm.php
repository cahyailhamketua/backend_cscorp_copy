<?php

namespace App\Filament\Resources\ContactSettings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContactSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email_receiver')
                    ->label('Email Penerima')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->placeholder('example@company.com')
                    ->helperText('Email yang akan menerima notifikasi dari form contact website'),
            ]);
    }
}
