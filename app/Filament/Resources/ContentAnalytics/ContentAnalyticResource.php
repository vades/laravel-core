<?php

namespace App\Filament\Resources\ContentAnalytics;

use App\Filament\Resources\ContentAnalytics\Pages\CreateContentAnalytic;
use App\Filament\Resources\ContentAnalytics\Pages\EditContentAnalytic;
use App\Filament\Resources\ContentAnalytics\Pages\ListContentAnalytics;
use App\Filament\Resources\ContentAnalytics\Schemas\ContentAnalyticForm;
use App\Filament\Resources\ContentAnalytics\Tables\ContentAnalyticsTable;
use App\Models\ContentAnalytic;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContentAnalyticResource extends Resource
{
    protected static ?string $model = ContentAnalytic::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Analytics';

    public static function form(Schema $schema): Schema
    {
        return ContentAnalyticForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContentAnalyticsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContentAnalytics::route('/'),
            'create' => CreateContentAnalytic::route('/create'),
            'edit' => EditContentAnalytic::route('/{record}/edit'),
        ];
    }
}
