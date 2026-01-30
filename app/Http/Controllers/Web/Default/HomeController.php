<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Post;
use App\Services\Album\AlbumService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $placesFeatured = Post::publishedByType('place')->isFeatured()->whereNotNull('options->featuredImage')->inRandomOrder()->orderBy('created_at','desc')->take(6)->get();
        $places =  Post::publishedByType('place')->notFeatured()->inRandomOrder()->orderBy('created_at','desc')->take(12)->get();
        $posts =  Post::publishedByType()->orderBy('created_at','desc')->take(10)->get();
        $defaultAlbum = config('myapp.album.default');
        $images = collect(AlbumService::fetchImages())
            ->filter(function ($image) use ($defaultAlbum) {
                return str_starts_with($image->parentId, $defaultAlbum);
            })
            ->shuffle()
            ->take(6)
            ->values()
            ->toArray();

        return view('components.web.' . config('myapp.project') . '.features.home.home-item', [
            'placesFeatured' => $placesFeatured,
            'places' => $places,
            'posts' => $posts,
            'defaultAlbum' => $defaultAlbum,
            'images' => $images
        ]);
    }
}