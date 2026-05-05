<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use App\Models\EventImage;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

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

    protected function afterSave(): void
    {
        $images = $this->data['images'] ?? [];

        if (!empty($images)) {
            foreach ((array) $images as $path) {
                // Only create if it doesn't exist yet (avoid duplicates)
                EventImage::firstOrCreate([
                    'event_id' => $this->getRecord()->id,
                    'image' => $path,
                ]);
            }
        }
    }
}
