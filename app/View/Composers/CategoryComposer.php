<?php
declare(strict_types=1);


namespace App\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryComposer
{
    private static array $cache = [];

    public function compose(View $view)
    {
        $categoryType = $view->getData()['categoryType'] ?? '';

        if (!isset(static::$cache[$categoryType])) {
            static::$cache[$categoryType] = Category::publishedByType($categoryType)
                                                    ->withCount('contents')
                                                    ->where('contents_count', '>', 0)
                                                    ->get();
        }

        $view->with([
                        'composerCategories' => static::$cache[$categoryType],
                        'composerCurrentCategory' => request()->query('category'),
                    ]);
    }
}