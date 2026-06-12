<?php
declare(strict_types=1);

namespace App\View\Composers;

use App\Queries\CategoryQuery;
use Illuminate\View\View;
use App\Enums\ContentContentType;

class CategoryComposer
{

    public function compose(View $view): void
    {

        $contentType = $view->getData()['categoryType'] ?? null;
        $view->with([
                        'composerCurrentCategory'  => request()->query('category'),
                        'composerCategory'       => [
                            'article' => (new CategoryQuery(ContentContentType::Article->value))->all(),
                            'place' => (new CategoryQuery(ContentContentType::Place->value))->all(),
                        ],
                    ]);
    }
}