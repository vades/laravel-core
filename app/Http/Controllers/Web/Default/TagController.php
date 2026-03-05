<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller
{

    public function index(Request $request): View
    {
        $contentType = basename($request->path());
        $meta =  Content::publishedByType(ContentContentType::Meta)->where('slug','tags-'. $contentType)->firstOrFail();
        $tags = Tag::ByContentType($contentType)
            ->withCount('contents')
            ->where('contents_count','>',0)
            ->orderByDesc('contents_count')
            ->get();
        return view('tag.index', [
            'page' => $meta,
            'tags' => $tags ?? [],
            'routeName' => $contentType . 'Index',
        ]);
    }
}