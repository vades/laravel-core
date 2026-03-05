<?php
declare(strict_types=1);


namespace App\View\Composers;

use App\Models\Tag;
use Illuminate\View\View;

class TagComposer
{
    public function compose(View $view)
    {
        // 1. Retrieve the data passed to the view
        $viewData = $view->getData();

        // 2. Extract 'type', defaulting to 'place' if missing to prevent errors
        $tagType = $viewData['tagType'] ?? '';

        // 3. Use the dynamic $type variable in your query

        $tags = Tag::byContentType($tagType)
                              ->withCount('contents')->where('contents_count','>',0)->get();

        $currentTag = request()->query('category', null);

        $view->with([
                        'composerTags' => $tags,
                        'composerCurrentTag' => $currentTag,
                    ]);
    }
}