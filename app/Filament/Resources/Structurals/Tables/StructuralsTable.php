<?php

namespace App\Filament\Resources\Structurals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StructuralsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('jabatan')
                    ->searchable(),
                ImageColumn::make('image')
                    ->disk('public')
                    ->label('Foto'),
                TextColumn::make('skills.pengalaman')
                    ->listWithLineBreaks()
                    ->label('Pengalaman')
                    ->limitList(2)
                    ->expandableLimitedList(),
                TextColumn::make('sosmeds.nama_sosmed')
                    ->listWithLineBreaks()
                    ->label('Media Sosial')
                    ->limitList(2)
                    ->expandableLimitedList(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
