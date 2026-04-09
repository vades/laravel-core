<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Tag;
use App\Queries\AlbumQuery;
use App\Queries\ContentQuery;
use App\Services\Album\AlbumService;
use App\Services\DomainManagerService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PhotoGalleryController extends Controller
{

    public function index(Request $request, AlbumQuery $album): View
    {
        $slug = basename($request->path());

        return view('photo-gallery.index', [
            'page' => (new ContentQuery)->meta($slug),
            'images' => $album->events(),
        ]);
    }

    public function show(string $slug,DomainManagerService $domainManager,AlbumQuery $album): View
    {
        $meta =  (new ContentQuery)->meta('photo-gallery');
        $event =  $album->eventByDirectory($slug);
        debug($event);

                           if(!empty($event->title)){
                               $meta->title = $meta->title .'  - ' .$event->title;
                           }

        return view('photo-gallery.show', [
            'page' =>  $meta ,
            'images' => $album->imagesByDirectory($slug),
        ]);
    }
}