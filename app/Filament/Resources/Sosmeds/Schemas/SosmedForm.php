<?php

namespace App\Filament\Resources\Sosmeds\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class SosmedForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('nama_sosmed')
                    ->required()
                    ->label('Nama Sosmed')
                    ->options([
                        'Instagram' => 'Instagram',
                        'Facebook' => 'Facebook',
                        'Twitter' => 'Twitter',
                        'LinkedIn' => 'LinkedIn',
                        'TikTok' => 'TikTok',
                        'YouTube' => 'YouTube',
                        'WhatsApp' => 'WhatsApp',
                        'Telegram' => 'Telegram',
                        'GitHub' => 'GitHub',
                        'Dribbble' => 'Dribbble',
                    ])
                    ->searchable(),
                TextInput::make('url')
                    ->required()
                    ->label('URL Sosmed')
                    ->url()
                    ->placeholder('https://...'),
            ]);
    }
}
