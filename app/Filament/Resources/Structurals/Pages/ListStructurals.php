<?php

namespace App\Filament\Resources\Structurals\Pages;

use App\Filament\Resources\Structurals\StructuralResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStructurals extends ListRecords
{
    protected static string $resource = StructuralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
