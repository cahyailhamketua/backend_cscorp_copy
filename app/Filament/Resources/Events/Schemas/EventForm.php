<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('judul')
                    ->label('Event')
                    ->required()
                    ->maxLength(255),
                Textarea::make('deskripsi')
                    ->required()
                    ->maxLength(1000)
                    ->columnSpanFull(),
                DatePicker::make('tanggal')
                    ->required(),
                TextInput::make('client')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('images')
                    ->label('Upload Images')
                    ->image()
                    ->multiple()
                    ->disk('public')
                    ->directory('events')
                    ->columnSpanFull()
                    ->nullable(),
            ]);
    }
}
