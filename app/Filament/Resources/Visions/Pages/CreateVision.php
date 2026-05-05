<?php

namespace App\Filament\Resources\Visions\Pages;

use App\Filament\Resources\Visions\VisionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVision extends CreateRecord
{
    protected static string $resource = VisionResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
