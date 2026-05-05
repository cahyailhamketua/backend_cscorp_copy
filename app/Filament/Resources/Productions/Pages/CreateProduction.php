<?php

namespace App\Filament\Resources\Productions\Pages;

use App\Filament\Resources\Productions\ProductionResource;
use App\Models\ProductionImage;
use Filament\Resources\Pages\CreateRecord;

class CreateProduction extends CreateRecord
{
    protected static string $resource = ProductionResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $images = $this->data['images'] ?? [];

        if (!empty($images)) {
            foreach ((array) $images as $path) {
                ProductionImage::create([
                    'production_id' => $this->getRecord()->id,
                    'image' => $path,
                ]);
            }
        }
    }
}
