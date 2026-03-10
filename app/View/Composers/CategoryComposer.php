<?php
declare(strict_types=1);


namespace App\View\Composers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CategoryComposer
{

    public function compose(View $view)
    {
        $categoryType = $view->getData()['categoryType'] ?? '';

        $categories = Cache::remember("categories.{$categoryType}", now()->addDay(), function () use ($categoryType) {
            return Category::publishedByType($categoryType)
                           ->withCount('contents')
                           ->where('contents_count', '>', 0)
                           ->get();
        });

        $view->with([
                        'composerCategories' => $categories ,
                        'composerCurrentCategory' => request()->query('category'),
                    ]);
    }
}