<?php

namespace App\Filament\Resources\Productions\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\CreateAction;

class ProductionImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $recordTitleAttribute = 'image';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->circular()
                    ->height(80),
                TextColumn::make('image')
                    ->label('Path')
                    ->wrap(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('image')
                ->image()
                ->disk('public')
                ->directory('productions')
                ->required(),
        ]);
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $this->form($schema);
    }

    public function defaultTable(Table $table): Table
    {
        return $this->table($table);
    }
}
