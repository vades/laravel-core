<?php
declare(strict_types=1);

namespace App\View\Composers;

use App\Models\Category;
use App\Services\Cache\CacheService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class CategoryComposer
{
    public function __construct(private CacheService $cache) {}

    public function compose(View $view): void
    {
        $categoryType = $view->getData()['categoryType'] ?? null;

        $categories = $this->cache->remember(
            cacheName:   'categories',
            callback:    fn() => Category::publishedByType($categoryType)
                                         ->whereHas('contents', function (Builder $subQuery) {
                                             $subQuery->withoutGlobalScope('project_scope');
                                         })
                                         ->withCount(['contents' => function (Builder $subQuery) {
                                             $subQuery->withoutGlobalScope('project_scope');
                                         }])
                                         ->get(),
            contentType: $categoryType,
        );

        $view->with([
                        'composerCategories'       => $categories,
                        'composerCurrentCategory'  => request()->query('category'),
                    ]);
    }
}