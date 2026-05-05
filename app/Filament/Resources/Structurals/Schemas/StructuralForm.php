<?php

namespace App\Filament\Resources\Structurals\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class StructuralForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('jabatan')
                    ->required(),
                Textarea::make('deskripsi')
                    ->required()
                    ->columnSpan('2')
                    ->rows(4),
                Repeater::make('skills')
                    ->relationship()
                    ->schema([
                        TextInput::make('pengalaman')
                            ->required()
                            ->label('Pengalaman'),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
                Repeater::make('sosmeds')
                    ->relationship()
                    ->schema([
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
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('structurals')
                    ->columnSpan('2')
                    ->imageEditor()
                    ->downloadable(),
            ]);
    }
}
