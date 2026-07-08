<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->required(),
                TextInput::make('url')
                    ->url()
                    ->required(),
                Textarea::make('excerpt')
                    ->columnSpanFull(),
                /*Textarea::make('metadata')
                    ->columnSpanFull(),*/
            ]);
    }
}
