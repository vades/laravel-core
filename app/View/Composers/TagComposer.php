<?php
declare(strict_types=1);


namespace App\View\Composers;

use App\Services\Cache\CacheService;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class TagComposer
{

    public function __construct(private CacheService $cache) {}
    public function compose(View $view)
    {
        // 1. Retrieve the data passed to the view
        $viewData = $view->getData();

        // 2. Extract 'type', defaulting to 'place' if missing to prevent errors
        $tagType = $viewData['tagType'] ?? null;

        // 3. Use the dynamic $type variable in your query

        $tags  = $this->cache->remember(
            cacheName:   'tags',
            callback:    fn() => Tag::byContentType($tagType)
                ->whereHas('contents', function (Builder $subQuery) {
                    $subQuery->withoutGlobalScope('project_scope');
                })
                ->withCount(['contents' => function (Builder $subQuery) {
                    $subQuery->withoutGlobalScope('project_scope');
                }])
                ->get(),
            contentType:    $tagType,
        );

        $currentTag = request()->query('tag', null);

        $view->with([
                        'composerTags' => $tags,
                        'composerCurrentTag' => $currentTag,
                    ]);
    }
}