<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Content;
use App\Queries\AlbumQuery;
use App\Queries\ContentQuery;
use App\Services\Album\AlbumService;
use App\Services\DomainManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

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
        return view('place.show', [
            'page'            => $content,
            'nextContent'     => $next     ? route('articleShow', ['slug' => $next->slug])     : null,
            'previousContent' => $previous ? route('articleShow', ['slug' => $previous->slug]) : null,
            'images' => $album->imagesByDirectory($slug),
            'highlights' => $query->byParentId(parentId:$content->id,take: 6, random: true),
            'related' =>  $query->setFilter('category',$categorySlugs)->filtered(),
        ]);
    }
}