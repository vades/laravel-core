<?php
declare(strict_types=1);

namespace App\View\Composers;

use App\Queries\CategoryQuery;
use Illuminate\View\View;

class CategoryComposer
{

    public function compose(View $view): void
    {

        $contentType = $view->getData()['categoryType'] ?? null;
        $view->with([
                        'composerCategories'       => (new CategoryQuery($contentType))->all(),
                        'composerCurrentCategory'  => request()->query('category'),
                    ]);
    }
}