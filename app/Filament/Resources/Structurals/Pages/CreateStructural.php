<?php

namespace App\Filament\Resources\Structurals\Pages;

use App\Filament\Resources\Structurals\StructuralResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStructural extends CreateRecord
{
    protected static string $resource = StructuralResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
