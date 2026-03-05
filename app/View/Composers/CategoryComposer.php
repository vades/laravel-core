<?php
declare(strict_types=1);


namespace App\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryComposer
{
    public function compose(View $view)
    {
        // 1. Retrieve the data passed to the view
        $viewData = $view->getData();

        // 2. Extract 'type', defaulting to 'place' if missing to prevent errors
        $categoryType = $viewData['categoryType'] ?? '';

        // 3. Use the dynamic $type variable in your query

        $categories = Category::publishedByType($categoryType)
                              ->withCount('contents')->where('contents_count','>',0)->get();

        $currentCategory = request()->query('category', null);

        $view->with([
                        'composerCategories' => $categories,
                        'composerCurrentCategory' => $currentCategory,
                    ]);
    }
}