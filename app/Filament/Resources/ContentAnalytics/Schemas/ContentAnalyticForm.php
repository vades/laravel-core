<?php

namespace App\Filament\Resources\ContentAnalytics\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ContentAnalyticForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('content_id')
                    ->relationship('content', 'title')
                    ->required(),
                TextInput::make('project_id')
                    ->required()
                    ->numeric(),
                TextInput::make('views')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('unique_views')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('downloads')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('last_viewed_at'),
                Textarea::make('metadata')
                    ->columnSpanFull(),
            ]);
    }
}
