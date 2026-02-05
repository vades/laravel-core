<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TagController extends Controller
{

    public function index(string $contentType): View
    {
        $tags = Tag::ByContentType($contentType)->withCount('contents')->where('contents_count','>',0)->get();
        $page = (object)[
            'title' => 'Blog Tag title',
            'subtitle' => 'Blog Tag subtitle',
            'metaTitle' => 'Blog Tag - Page Meta Title',
            'keywords' => 'Blog, Tag, Page, keywords',
            'metaDescription' => 'Blog Tag - Page meta description',
            'tags' => $tags,
        ];
        return view('tag.index', [
            'page' => $page
        ]);
    }
}