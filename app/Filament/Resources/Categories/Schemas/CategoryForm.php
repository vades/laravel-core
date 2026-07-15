<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Enums\ContentContentType;
use App\Enums\ContentStatus;
use App\Enums\ContentVisibility;
use App\Enums\Language;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'slug')
                    ->required(),
                Select::make('parent_id')
                    ->relationship('parent', 'title'),
                Select::make('status')
                    ->options(ContentStatus::class)
                    ->default('draft')
                    ->required(),
                Select::make('visibility')
                    ->options(ContentVisibility::class)
                    ->default('public')
                    ->required(),
                Select::make('content_type')
                    ->options(ContentContentType::class)
                    ->required(),
                TextInput::make('position')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('slug')
                    ->required(),
                Select::make('lang')
                    ->options(Language::class)
                    ->default('en')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('excerpt')
                    ->columnSpanFull(),
                /*Textarea::make('metadata')
                    ->columnSpanFull(),*/
            ]);
    }
}
