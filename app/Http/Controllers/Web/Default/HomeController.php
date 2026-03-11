<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $meta =  Content::publishedByType(ContentContentType::Meta)->where('slug','home')->first();
        $articles = Content::publishedByType()
                           ->filter($request)
                           ->latest()
                           ->take(6)
                           ->get();

        return view('home.index',  [
            'page' => $meta ?? null,
            'articles' => $articles ?? [],
        ]);
    }
}