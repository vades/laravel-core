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
        $page = Content::publishedByType('page')->where('slug', $slug)->firstOrFail();
        $viewData = [
            'typee' =>'test', // This maps to :pcontentType="$typee"
            'user'  => auth()->user(), // This would map to :user="$user"
            'now'   => now(),
        ];
        return view('page.index', [
            'markdown' =>  Str::of($page->content)->markdown(),
            'renderedBody' => $page->renderContent($viewData),
            'page' => $page,
        ]);
    }
}