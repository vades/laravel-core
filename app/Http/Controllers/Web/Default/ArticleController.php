<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Content;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $contentType = basename($request->path());
        $meta =  Content::publishedByType(ContentContentType::Meta)->where('slug',$contentType)->firstOrFail();

        $contents = Content::publishedByType()->filter($request)->orderBy('created_at','desc')
                     ->paginate(20);

        return view(
            'article.index',
            [
                'page' => $meta,
                'articles' => $contents ?? [],
            ]
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(string $slug): View
    {
        $article =  Content::publishedByType()->where('slug', $slug)->with('user')->firstOrFail();
        $nextContent= $article->nextPublishedByType(ContentContentType::Article);
        $viewMode=$article['viewMode'] ?? 'default';
        $postImages = null;
    /*    if($content['eventDirectory'] !== null){
            $postImages = collect(AlbumService::fetchPostImages())->where('directory', $content['eventDirectory'])->values()
                                                                  ->toArray();
        }*/

        $previousContent= $article->previousPublishedByType(ContentContentType::Article);
        return view('article.show-' .$viewMode, [
            'markdown' =>  Str::of($article->content)->markdown(),
            'page' => $article,
            'nextContent' => $nextContent? route('articleShow',  ['slug'=>$nextContent->slug]) : null,
            'previousContent' => $previousContent? route('articleShow',  ['slug'=>$previousContent->slug]) : null,
            'postImages' => $postImages
        ]);
    }
}