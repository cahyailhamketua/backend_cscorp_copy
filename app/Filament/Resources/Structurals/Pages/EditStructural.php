<?php

namespace App\Filament\Resources\Structurals\Pages;

use App\Filament\Resources\Structurals\StructuralResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStructural extends EditRecord
{
    protected static string $resource = StructuralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
