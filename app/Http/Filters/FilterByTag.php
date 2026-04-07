<?php
declare(strict_types=1);


namespace App\Http\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
class FilterByTag implements Filter
{
    public function __invoke(Builder $query, $value, string $property): void
    {
        $query->whereHas('tags', function (Builder $q) use ($value) {
            $q->where('name', '=', $value);
        });
    }
}