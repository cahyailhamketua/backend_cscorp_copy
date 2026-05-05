<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('whatsapp')
                    ->label('WhatsApp')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('working_hours')
                    ->label('Working Hours')
                    ->maxLength(255)
                    ->placeholder('e.g., Mon-Fri 9AM-5PM'),
            ]);
    }
}
