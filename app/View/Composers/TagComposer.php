<?php
declare(strict_types=1);


namespace App\View\Composers;

use App\Queries\TagQuery;
use Illuminate\View\View;

class TagComposer
{
    public function compose(View $view)
    {
        $contentType = $view->getData()['tagType'] ?? null;

        $view->with([
                        'composerTags' =>  (new TagQuery($contentType))->all(),
                        'composerCurrentTag' =>  request()->query('tag', null),
                    ]);
    }
}