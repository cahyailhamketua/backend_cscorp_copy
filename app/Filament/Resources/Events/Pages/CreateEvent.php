<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use App\Models\EventImage;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $images = $this->data['images'] ?? [];

        if (!empty($images)) {
            foreach ((array) $images as $path) {
                EventImage::create([
                    'event_id' => $this->getRecord()->id,
                    'image' => $path,
                ]);
            }
        }
    }
}
