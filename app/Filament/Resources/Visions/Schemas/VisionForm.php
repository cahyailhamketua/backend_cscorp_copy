<?php

namespace App\Filament\Resources\Visions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VisionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('visi')
                    ->required(),
                Textarea::make('misi')
                    ->required(),
            ]);
    }
}
