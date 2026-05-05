<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_client')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                FileUpload::make('icon')
                    ->required()
                    ->disk('public')
                    ->directory('clients')
                    ->imageEditor()
                    ->downloadable()
                    ->columnSpanFull(),
            ]);
    }
}
