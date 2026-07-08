<?php

namespace App\Filament\Resources\Contents\Schemas;

use App\Enums\ContentContentType;
use App\Enums\ContentStatus;
use App\Enums\ContentVisibility;
use App\Enums\Language;
use App\Models\Project;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ContentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic settings')
                    ->schema([

                        Select::make('project_id')
                            ->relationship('project', 'slug')
                            ->required()
                            ->live(),

                        Select::make('content_type')
                            ->options(ContentContentType::class)
                            ->required()
                            ->live()
                            ->live(),
                        Select::make('status')
                            ->options(ContentStatus::class)
                            ->default('draft')
                            ->required(),
                        Select::make('parent_id')
                            ->relationship('parent', 'title'),

                    ])
                    ->columns(4)
                    ->columnSpanFull(),
                Section::make('Main content')
                    ->schema([

                TextInput::make('title')
                    ->required(),
                TextInput::make('subtitle'),
                Textarea::make('excerpt')
                    ->columnSpanFull(),
                MarkdownEditor::make('content')
                    ->columnSpanFull(),
                        Toggle::make('is_featured')
                            ->required(),
                        DateTimePicker::make('published_at'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('SEO')
                    ->schema([

                        TextInput::make('metadata.metaTitle')
                            ->label('Meta title'),

                        Textarea::make('metadata.metaDescription')
                            ->label('Meta description')->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Images')
                    ->schema([

                        FileUpload::make('metadata.coverImage')
                            ->label('Cover Image')
                            ->image()
                            ->disk('public')
                            ->directory(function (Get $get): string {
                                $projectSlug = Project::find($get('project_id'))?->slug ?? 'unknown';

                                $contentType = $get('content_type');
                                $contentType = $contentType instanceof ContentContentType
                                    ? $contentType->value
                                    : ($contentType ?? 'unknown');

                                return "images/{$projectSlug}/{$contentType}";
                            })
                            ->visibility('public'),

                        FileUpload::make('metadata.featuredImage')
                            ->label('Featured Image')
                            ->image()
                            ->disk('public')
                            ->directory(function (Get $get): string {
                                $projectSlug = Project::find($get('project_id'))?->slug ?? 'unknown';

                                $contentType = $get('content_type');
                                $contentType = $contentType instanceof ContentContentType
                                    ? $contentType->value
                                    : ($contentType ?? 'unknown');

                                return "images/{$projectSlug}/{$contentType}";
                            })
                            ->visibility('public'),

                        /*TextInput::make('metadata.coverImage')
                            ->label('Cover Image Path'),*/
                       /* FileUpload::make('metadata.coverImage')
                            ->label('Cover Image')
                            ->image()
                            ->directory('imagetest'),*/
                       /* FileUpload::make('metadata.coverImage')
                            ->label('Cover Image')
                            ->image()
                            ->disk('public')
                            ->directory('articles')
                            ->visibility('public'),*/

                        /*TextInput::make('metadata.featuredImage')
                            ->label('Featured Image Path'),*/
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Location')
                    ->schema([
                        TextInput::make('metadata.address')
                            ->label('Address')
                            ->columnSpanFull(),

                        TextInput::make('metadata.latitude')
                            ->label('Latitude')
                            ->numeric(),

                        TextInput::make('metadata.longitude')
                            ->label('Longitude')
                            ->numeric(),

                        TextInput::make('metadata.googleMapUrl')
                            ->label('Google Map URL')
                            ->url()
                            ->columnSpanFull(),

                        TextInput::make('metadata.googleMapEmbedUrl')
                            ->label('Google Map Embed URL')
                            ->url()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('content_type') === ContentContentType::Place)
                    ->dehydrated(fn (Get $get): bool => $get('content_type') === ContentContentType::Place),
                Section::make('Settings')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required(),
                        Select::make('author_id')
                            ->relationship('author', 'name'),


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

                        TextInput::make('position')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),



            ]);
    }
}
