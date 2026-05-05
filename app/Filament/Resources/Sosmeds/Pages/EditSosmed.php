<?php

namespace App\Filament\Resources\Sosmeds\Pages;

use App\Filament\Resources\Sosmeds\SosmedResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSosmed extends EditRecord
{
    protected static string $resource = SosmedResource::class;

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
