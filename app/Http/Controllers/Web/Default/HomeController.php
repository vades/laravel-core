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
        $meta = Content::publishedByType(ContentContentType::Meta)->where('slug', 'home')->first();
        $placesFeatured = Content::publishedByType(ContentContentType::Place)
                                 ->filter($request)
                                 ->isFeatured()
                                 ->latest()
                                 ->take(6)
                                 ->get()
        ;
        $places = Content::publishedByType(ContentContentType::Place)
                         ->filter($request)
                         ->latest()
                         ->notFeatured()
                         ->take(6)
                         ->get()
        ;

        $articles = Content::publishedByType()
                           ->filter($request)
                           ->latest()
                           ->take(6)
                           ->get()
        ;

        return view('home.index', [
            'page' => $meta,
            'placesFeatured' => $placesFeatured ?? [],
            'places' => $places ?? [],
            'articles' => $articles ?? [],
            'images' => [],

        ]);
    }
}