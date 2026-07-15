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
                    ->relationship('project', 'slug')
                    ->disabled(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->disabled(),
                Toggle::make('is_read')
                    ->required(),
                Toggle::make('is_spam')
                    ->required(),
                Toggle::make('is_archived')
                    ->required(),
                TextInput::make('name')
                    ->disabled(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->disabled(),
                TextInput::make('subject')->disabled(),
                Textarea::make('message')
                    ->disabled()
                    ->columnSpanFull(),
                TextInput::make('ip_address')->disabled(),
                TextInput::make('user_agent')->disabled(),
                TextInput::make('terms_accepted_at')->disabled(),

            ]);
    }
}
