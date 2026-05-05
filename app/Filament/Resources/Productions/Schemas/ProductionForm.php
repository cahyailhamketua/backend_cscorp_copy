<?php

namespace App\Filament\Resources\Productions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('judul')
                    ->label('Production')
                    ->required()
                    ->maxLength(255),
                Textarea::make('deskripsi')
                    ->required()
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
                    ->directory('productions')
                    ->columnSpanFull()
                    ->nullable(),
            ]);
    }
}
