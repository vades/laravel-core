<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Http\Filters\FilterByCategory;
use App\Http\Filters\FilterByTag;
use App\Models\Category;
use App\Models\Content;
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
        $contentType = basename($request->path());
        $meta =  Content::publishedByType(ContentContentType::Meta)->where('slug',$contentType)->firstOrFail();

        $contents = QueryBuilder::for(Content::publishedByType(ContentContentType::Place))
                                ->allowedFilters(
                                    AllowedFilter::custom('category', new FilterByCategory()),
                                    AllowedFilter::custom('tag', new FilterByTag())
                                )
                                ->allowedIncludes('categories', 'tags')
                                ->with(['categories', 'tags'])
                                ->orderBy('created_at', 'desc')
                                ->paginate(20);

        return view(
            'place.index',
            [
                'page' => $meta,
                'contents' => $contents ?? [],
            ]
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(string $slug, DomainManagerService $domainManager): View
    {
        $content =  Content::publishedByType(ContentContentType::Place)->where('slug', $slug)->with('user')->firstOrFail();
        $nextContent= $content->nextPublishedByType(ContentContentType::Place);
        $images = collect(AlbumService::getImages($domainManager->getSlug()))->where('directory', $slug)->values()->toArray();

        $highlights = Content::publishedByType('place')->where('parent_id',64)->inRandomOrder()->take(6)
                                                                                                        ->get();
        $categorySlugs = $content->categories->pluck('slug')->toArray();
        $placesByCategory = Content::publishedByType('place')
                                ->whereHas('categories', function ($query) use ($categorySlugs) {
                                    $query->whereIn('slug', $categorySlugs);
                                })
                                ->where('slug', '!=', $slug)
                                ->inRandomOrder()
                                ->take(6)
                                ->get();

        $previousContent= $content->previousPublishedByType(ContentContentType::Place);
        return view('place.show', [
            'markdown' =>  Str::of($content->content)->markdown(),
            'page' => $content,
            'nextContent' => $nextContent? route('placeShow',  ['slug'=>$nextContent->slug]) : null,
            'previousContent' => $previousContent? route('placeShow',  ['slug'=>$previousContent->slug]) : null,
            'images' => $images,
            'highlights' =>  $highlights ?? [],
            'related' => $placesByCategory ?? [],
        ]);
    }
}