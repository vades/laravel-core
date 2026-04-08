<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Queries\AlbumQuery;
use App\Queries\ContentQuery;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, AlbumQuery $album): View
    {
        $places   = new ContentQuery(ContentContentType::Place);
        $articles = new ContentQuery(ContentContentType::Article);

        return view('home.index', [
            'page'           => (new ContentQuery)->meta('home'),
            'placesFeatured' => $places->featured(take: 6),
            'places'         => $places->latest(take: 12, excludeFeatured: true),
            'articles'       => $articles->latest(take: 6),
            'images'         => $album->homeImages(),
        ]);
    }
}