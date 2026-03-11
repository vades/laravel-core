<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Services\Album\AlbumService;
use App\Services\DomainManagerService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request,DomainManagerService $domainManager): View
    {
        $meta = Content::publishedByType(ContentContentType::Meta)->where('slug', 'home')->first();
        $placesFeatured = Content::publishedByType(ContentContentType::Place)
                                 ->filter($request)
                                 ->isFeatured()
                                 ->latest()
            ->inRandomOrder()
                                 ->take(6)
                                 ->get()
        ;
        $places = Content::publishedByType(ContentContentType::Place)
                         ->filter($request)
                         ->latest()
                         ->notFeatured()
            ->inRandomOrder()
                         ->take(12)
                         ->get()
        ;

        $articles = Content::publishedByType()
                           ->filter($request)
                           ->latest()
                           ->take(6)
                           ->get()
        ;
        $images = collect(AlbumService::getImages($domainManager->getSlug()))->shuffle()
                                                                                ->take(6)->values()->toArray();

        return view('home.index', [
            'page' => $meta,
            'placesFeatured' => $placesFeatured ?? [],
            'places' => $places ?? [],
            'articles' => $articles ?? [],
            'images' => $images ?? [],

        ]);
    }
}