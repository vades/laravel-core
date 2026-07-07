<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'id')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name'),
                Toggle::make('is_read')
                    ->required(),
                Toggle::make('is_spam')
                    ->required(),
                Toggle::make('is_archived')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('subject'),
                Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('ip_address'),
                TextInput::make('user_agent'),
                DateTimePicker::make('terms_accepted_at'),
                Textarea::make('metadata')
                    ->columnSpanFull(),
            ]);
    }
}
