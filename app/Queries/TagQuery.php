<?php
declare(strict_types=1);


namespace App\Queries;

use App\Enums\ContentContentType;
use App\Models\Content;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TagQuery
{
    private array $filters = [];

    public function __construct(private ContentContentType|string|null $contentType = null) {}


    public function all(): Collection
    {
        return Tag::byContentType($this->contentType)
                  ->withCount('contents')
                  ->where('contents_count', '>', 0)
                  ->orderByDesc('contents_count')
                  ->get()
        ;
    }
}