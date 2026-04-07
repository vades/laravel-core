<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Http\Filters\FilterByCategory;
use App\Http\Filters\FilterByTag;
use App\Models\Category;
use App\Models\Content;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $contentType = basename($request->path());
        $meta =  Content::publishedByType(ContentContentType::Meta)->where('slug',$contentType)->firstOrFail();

        $contents = QueryBuilder::for(Content::publishedByType(ContentContentType::Article))
                                ->allowedFilters(
                                    AllowedFilter::custom('category', new FilterByCategory()),
                                    AllowedFilter::custom('tag', new FilterByTag())
                                )
                                ->allowedIncludes('categories', 'tags')
                                ->with(['categories', 'tags'])
                                ->orderBy('created_at', 'desc')
                                ->paginate(20);

        return view(
            'article.index',
            [
                'page' => $meta,
                'contents' => $contents ?? [],
            ]
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(string $slug): View
    {
        $content =  Content::publishedByType()->where('slug', $slug)->with('user')->firstOrFail();
        $nextContent= $content->nextPublishedByType(ContentContentType::Article);
        $viewMode=$content['viewMode'] ?? 'default';
        $postImages = null;
    /*    if($content['eventDirectory'] !== null){
            $postImages = collect(AlbumService::fetchPostImages())->where('directory', $content['eventDirectory'])->values()
                                                                  ->toArray();
        }*/

        $previousContent= $content->previousPublishedByType(ContentContentType::Article);
        return view('article.show-' .$viewMode, [
            'markdown' =>  Str::of($content->content)->markdown(),
            'page' => $content,
            'nextContent' => $nextContent? route('articleShow',  ['slug'=>$nextContent->slug]) : null,
            'previousContent' => $previousContent? route('articleShow',  ['slug'=>$previousContent->slug]) : null,
            'postImages' => $postImages
        ]);
    }
}