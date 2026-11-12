<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Queries\AlbumQuery;
use App\Queries\ContentQuery;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\Album\AlbumService;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {

        $query = new ContentQuery(ContentContentType::Place);


        return view(
            'place.index',
            [
                'page'     => $query->meta(basename($request->path())),
                'contents' => $query->filtered(),
            ]
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(string $slug, AlbumQuery $album): View
    {
        $query   = new ContentQuery(ContentContentType::Place);
        $content = $query->findBySlug($slug);

        $next     = $content->nextPublishedByType(ContentContentType::Place);
        $previous = $content->previousPublishedByType(ContentContentType::Place);

        $categorySlugs = $content->categories->pluck('slug')->toArray();
        $images = $album->imagesByDirectory($slug);
        if ($content->hasAlbumEvent) {
            $this->getAlbumEvent($content->hasAlbumEvent);
        }
        return view('place.show', [
            'page'            => $content,
            'nextContent'     => $next     ? route('placeShow', ['slug' => $next->slug])     : null,
            'previousContent' => $previous ? route('placeShow', ['slug' => $previous->slug]) : null,
            'images' => $images,
            'highlights' => $query->byParentId(parentId: $content->id, take: 6, random: true),
            'related' =>  $query->setFilter('category', $categorySlugs)->filtered(),
        ]);
    }

    private function getAlbumEvent(string $path): array
    {
        if (!is_string($path) || trim($path) === '') {
            return [];
        }

        $parts = explode('/', trim($path, '/'));

        if (count($parts) !== 2 || $parts[0] === '' || $parts[1] === '') {
            return [];
        }

        [$album, $event] = $parts;

        $take = (int) ($options['take'] ?? 0);

        $images = collect(AlbumService::getImages($album))
            ->where('directory', $event)
            ->when($take > 0, fn($q) => $q->take($take))
            ->values()
            ->toArray();

        if (empty($images)) {
            return [];;
        }
        return $images;
    }
}
