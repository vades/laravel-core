<?php
declare(strict_types=1);

namespace App\View\Composers;

use App\Models\Category;
use App\Services\Cache\CacheService;
use Illuminate\View\View;

class CategoryComposer
{
    public function __construct(private CacheService $cache) {}

    public function compose(View $view): void
    {
        $categoryType = $view->getData()['categoryType'] ?? '';

        $categories = $this->cache->remember(
            cacheName:   'categories',
            callback:    fn() => Category::publishedByType($categoryType)
                                         ->withCount('contents')
                                         ->where('contents_count', '>', 0)
                                         ->get(),
            contentType: $categoryType ?: null,
        );

        $view->with([
                        'composerCategories'       => $categories,
                        'composerCurrentCategory'  => request()->query('category'),
                    ]);
    }
}