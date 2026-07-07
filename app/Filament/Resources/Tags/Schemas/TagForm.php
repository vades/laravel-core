<?php

namespace App\Filament\Resources\Tags\Schemas;

use App\Enums\Language;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'id')
                    ->required(),
                TextInput::make('content_type')
                    ->required(),
                Select::make('lang')
                    ->options(Language::class)
                    ->default('en')
                    ->required(),
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
