<?php

namespace App\Filament\Resources\Productions\Pages;

use App\Filament\Resources\Productions\ProductionResource;
use App\Models\ProductionImage;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduction extends EditRecord
{
    protected static string $resource = ProductionResource::class;

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
                ProductionImage::firstOrCreate([
                    'production_id' => $this->getRecord()->id,
                    'image' => $path,
                ]);
            }
        }
    }
}
