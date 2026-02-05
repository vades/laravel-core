<?php

namespace App\Http\Controllers\Web\Default;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $slug): View
    {
        $content = Content::publishedByType('page')->where('slug', $slug)->firstOrFail();
        return view('page.index', [
            'markdown' =>  Str::of($content->content)->markdown(),
            'page' => $content,
        ]);
    }
}