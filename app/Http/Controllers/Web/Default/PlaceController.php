<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PlaceController extends Controller
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
            'place.index',
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
        $postImages = null;

        $previousContent= $article->previousPublishedByType(ContentContentType::Article);
        return view('place.show', [
            'markdown' =>  Str::of($article->content)->markdown(),
            'page' => $article,
            'nextContent' => $nextContent? route('articleShow',  ['slug'=>$nextContent->slug]) : null,
            'previousContent' => $previousContent? route('articleShow',  ['slug'=>$previousContent->slug]) : null,
            'postImages' => $postImages
        ]);
    }
}