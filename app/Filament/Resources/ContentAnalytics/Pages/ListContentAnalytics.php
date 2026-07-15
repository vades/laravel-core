<?php

namespace App\Filament\Resources\ContentAnalytics\Pages;

use App\Filament\Resources\ContentAnalytics\ContentAnalyticResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContentAnalytics extends ListRecords
{
    protected static string $resource = ContentAnalyticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
