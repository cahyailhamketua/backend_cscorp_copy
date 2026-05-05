<?php

namespace App\Filament\Resources\Sosmeds\Pages;

use App\Filament\Resources\Sosmeds\SosmedResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSosmeds extends ListRecords
{
    protected static string $resource = SosmedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
