<?php
declare(strict_types=1);


namespace App\Queries;

use App\Enums\ContentContentType;
use App\Models\Content;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ContentQuery
{
    private array $filters = [];

    public function __construct(private ?ContentContentType $contentType = null) {}

    public function setFilter(string $key, mixed $value): static
    {
        $this->filters[$key] = $value;
        return $this;
    }

    public function meta(string $slug): Content
    {
        return Content::publishedByType(ContentContentType::Meta)
                      ->where('slug', $slug)
                      ->firstOrFail()
        ;
    }

    public function findBySlug(string $slug, array $with = []): Content
    {
        return Content::publishedByType($this->contentType)
                      ->where('slug', $slug)
                      ->with($with)
                      ->firstOrFail()
        ;
    }

    public function featured(?int $take = null, bool $random = false,): Collection
    {
        return Content::publishedByType($this->contentType)
                      ->isFeatured()
                      ->when($random, fn($q) => $q->inRandomOrder())
                      ->latest()
                      ->when($take > 0, fn($q) => $q->take($take))
                      ->get()
        ;
    }

    public function latest(?int $take = null, bool $random = false, bool $excludeFeatured = false): Collection
    {
        return Content::publishedByType($this->contentType)
                      ->when($excludeFeatured, fn($q) => $q->notFeatured())
                      ->when($random, fn($q) => $q->inRandomOrder())
                      ->latest()
                      ->when($take > 0, fn($q) => $q->take($take))
                      ->get()
        ;
    }

    public function byParentId(int $parentId, ?int $take = null, bool $random = false): Collection
    {
        return Content::publishedByType($this->contentType)
                      ->where('parent_id', $parentId)
                      ->when($random, fn($q) => $q->inRandomOrder())
                      ->latest()
                      ->when($take > 0, fn($q) => $q->take($take))
                      ->get()
        ;
    }

    public function filtered(int $perPage = 20): LengthAwarePaginator|Collection
    {
        $query = QueryBuilder::for(Content::publishedByType($this->contentType))
                             ->allowedFilters(
                                 AllowedFilter::scope('category', 'filterByCategory'),
                                 AllowedFilter::scope('tag', 'filterByTag'),
                             )
                             ->allowedIncludes('categories', 'tags')
                             ->with(['categories', 'tags'])
                             ->when(
                                 isset($this->filters['category']),
                                 fn($q) => $q->filterByCategory(
                                     is_array($this->filters['category'])
                                         ? $this->filters['category']
                                         : [$this->filters['category']]
                                 )
                             )
                             ->when(
                                 isset($this->filters['tag']),
                                 fn($q) => $q->filterByTag(
                                     is_array($this->filters['tag'])
                                         ? $this->filters['tag']
                                         : [$this->filters['tag']]
                                 )
                             )
                             ->orderBy('created_at', 'desc')
        ;

        return $perPage > 0
            ? $query->paginate($perPage)
            : $query->get();
    }
}