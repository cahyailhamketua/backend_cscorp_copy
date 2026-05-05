<?php

namespace App\Filament\Resources\Visions\Pages;

use App\Filament\Resources\Visions\VisionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVision extends EditRecord
{
    protected static string $resource = VisionResource::class;

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
