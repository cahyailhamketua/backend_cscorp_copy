<?php

namespace App\Filament\Resources\Sosmeds\Pages;

use App\Filament\Resources\Sosmeds\SosmedResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSosmed extends CreateRecord
{
    protected static string $resource = SosmedResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
