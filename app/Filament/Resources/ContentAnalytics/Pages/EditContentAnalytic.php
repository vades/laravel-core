<?php

namespace App\Filament\Resources\ContentAnalytics\Pages;

use App\Filament\Resources\ContentAnalytics\ContentAnalyticResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContentAnalytic extends EditRecord
{
    protected static string $resource = ContentAnalyticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
