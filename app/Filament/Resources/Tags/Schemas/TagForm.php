<?php

namespace App\Filament\Resources\Tags\Schemas;

use App\Enums\ContentContentType;
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
                    ->relationship('project', 'slug')
                    ->required(),
                Select::make('content_type')
                    ->options(ContentContentType::class)
                    ->default(ContentContentType::Article)
                    ->required(),
                Select::make('lang')
                    ->options(Language::class)
                    ->default(Language::EN)
                    ->required(),
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
