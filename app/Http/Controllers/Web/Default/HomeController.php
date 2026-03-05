<?php

namespace App\Http\Controllers\Web\Default;

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
        $articles = Content::publishedByType()
                           ->filter($request)
                           ->latest()
                           ->take(6)
                           ->get();

        return view('home.index',  [
            'articles' => $articles ?? [],
        ]);
    }
}