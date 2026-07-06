<?php
declare(strict_types=1);


namespace App\Queries;

use App\Enums\ContentContentType;
use App\Models\Tag;
use App\Services\Cache\CacheService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TagQuery
{
    private array $filters = [];

    public function __construct(private ContentContentType|string|null $contentType = null) {}


    public function all(): Collection
    {

        return (new CacheService)->remember(
            cacheName:   'tags',
            callback:    fn() => Tag::byContentType($this->contentType)
                                    ->whereHas('contents', function (Builder $subQuery) {
                                        $subQuery->withoutGlobalScope('project_scope');
                                    })
                                    ->withCount(['contents' => function (Builder $subQuery) {
                                        $subQuery->withoutGlobalScope('project_scope');
                                    }])
                                    ->get(),
            contentType:   $this->contentType,
        );
    }
}