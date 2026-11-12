<?php

declare(strict_types=1);

namespace App\View\Composers;

use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CarouselComposer
{
    public function compose(View $view): void
    {
        $portfolioDirectory = 'images/vades/portfolio';
        $allowedExtensions = ['jpg', 'gif', 'png'];

        $images = collect(Storage::disk('public')->files($portfolioDirectory))
            ->filter(function (string $filePath) use ($allowedExtensions): bool {
                return in_array(strtolower(pathinfo($filePath, PATHINFO_EXTENSION)), $allowedExtensions, true);
            })
            ->map(function (string $filePath): string {
                return asset('storage/'.$filePath);
            })
            ->values()
            ->all();

        $view->with([
            'composerImages' => $images,
        ]);
    }
}
