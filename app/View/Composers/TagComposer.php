<?php
declare(strict_types=1);


namespace App\View\Composers;

use App\Models\Tag;
use Illuminate\View\View;

class TagComposer
{
    private static array $cache = [];

    public function compose(View $view)
    {
        // 1. Retrieve the data passed to the view
        $viewData = $view->getData();

        // 2. Extract 'type', defaulting to 'place' if missing to prevent errors
        $tagType = $viewData['tagType'] ?? '';

        // 3. Use cached query result, keyed by type
        if (!isset(static::$cache[$tagType])) {
            static::$cache[$tagType] = Tag::byContentType($tagType)
                                          ->withCount('contents')
                                          ->where('contents_count', '>', 0)
                                          ->get();
        }

        $currentTag = request()->query('category', null);

        $view->with([
                        'composerTags' => static::$cache[$tagType],
                        'composerCurrentTag' => $currentTag,
                    ]);
    }
}