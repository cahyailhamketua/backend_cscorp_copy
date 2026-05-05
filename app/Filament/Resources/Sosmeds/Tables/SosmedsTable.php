<?php

namespace App\Filament\Resources\Sosmeds\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SosmedsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_sosmed')
                    ->label('Sosmed')
                    ->searchable(),
                TextColumn::make('url')
                    ->label('URL')
                    ->searchable()
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab(),
                TextColumn::make('icon_class')
                    ->label('Icon Class')
                    ->searchable(),
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
