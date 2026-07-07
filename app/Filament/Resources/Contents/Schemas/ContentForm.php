<?php

namespace App\Filament\Resources\Contents\Schemas;

use App\Enums\ContentContentType;
use App\Enums\ContentStatus;
use App\Enums\ContentVisibility;
use App\Enums\Language;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('uuid')
                    ->label('UUID')
                    ->required(),
                Select::make('project_id')
                    ->relationship('project', 'id')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('author_id')
                    ->relationship('author', 'name'),
                Select::make('parent_id')
                    ->relationship('parent', 'title'),
                Select::make('content_type')
                    ->options(ContentContentType::class)
                    ->required(),
                Select::make('status')
                    ->options(ContentStatus::class)
                    ->default('draft')
                    ->required(),
                Select::make('visibility')
                    ->options(ContentVisibility::class)
                    ->default('public')
                    ->required(),
                Select::make('lang')
                    ->options(Language::class)
                    ->default('en')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('subtitle'),
                Textarea::make('excerpt')
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->columnSpanFull(),
                Textarea::make('metadata')
                    ->columnSpanFull(),
                TextInput::make('position')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_featured')
                    ->required(),
                DateTimePicker::make('published_at'),
            ]);
    }
}
