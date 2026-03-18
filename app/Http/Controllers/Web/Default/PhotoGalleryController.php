<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Tag;
use App\Services\Album\AlbumService;
use App\Services\DomainManagerService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PhotoGalleryController extends Controller
{

    public function index(Request $request, DomainManagerService $domainManager): View
    {
        $slug = basename($request->path());
        $meta =  Content::publishedByType(ContentContentType::Meta)->where('slug',$slug)->firstOrFail();
        $images = collect(AlbumService::getEvents($domainManager->getSlug()));
        return view('photo-gallery.index', [
            'page' => $meta,
            'images' => $images ?? [],
        ]);
    }

    public function show(string $slug,DomainManagerService $domainManager): View
    {
        $meta =  Content::publishedByType(ContentContentType::Meta)->where('slug','photo-gallery')->firstOrFail();
        $images = collect(AlbumService::getImages($domainManager->getSlug()))->where('directory', $slug)->values()->toArray();
        $event =  collect(AlbumService::getEvents($domainManager->getSlug()))->firstWhere('directory', $slug);

                           if(!empty($event->title)){
                               $meta->title = $meta->title .'  - ' .$event->title;
                           }

        return view('photo-gallery.show', [
           'page' => $meta,
            'images' => $images ?? [],
        ]);
    }
}