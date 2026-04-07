<?php
declare(strict_types=1);


namespace App\Http\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterByCategory implements Filter
{
    public function __invoke(Builder $query, $value, string $property): void
    {
        $query->whereHas('categories', function (Builder $q) use ($value) {
            $q ->where('slug', '=', $value);
        });
    }
}