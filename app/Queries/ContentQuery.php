<?php
declare(strict_types=1);


namespace App\Queries;

use App\Enums\ContentContentType;
use App\Models\Content;
use App\Services\Album\AlbumService;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;

class ContentQuery
{
    public function __construct(private ContentContentType $contentType) {}

    public function meta(string $slug): Content
    {
        return Content::publishedByType(ContentContentType::Meta)
                      ->where('slug', $slug)
                      ->firstOrFail();
    }

    public function findBySlug(string $slug, array $with = []): Content
    {
        return Content::publishedByType($this->contentType)
                      ->where('slug', $slug)
                      ->with($with)
                      ->firstOrFail();
    }
    public function paginated(int $perPage = 20): LengthAwarePaginator
    {

        return QueryBuilder::for(Content::publishedByType($this->contentType))
                           ->allowedFilters(
                               AllowedFilter::scope('category', 'filterByCategory'),
                               AllowedFilter::scope('tag', 'filterByTag'),
                           )
                           ->allowedIncludes('categories', 'tags')
                           ->with(['categories', 'tags'])
                           ->orderBy('created_at', 'desc')
                           ->paginate($perPage);
    }

    public function postImages(Content $content): ?array
    {
        if (blank($content['eventDirectory'])) {
            return null;
        }
        return null;

      /*  return collect(AlbumService::fetchPostImages())
            ->where('directory', $content['eventDirectory'])
            ->values()
            ->toArray();*/
    }
}