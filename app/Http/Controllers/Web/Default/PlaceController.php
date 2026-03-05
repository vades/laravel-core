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

        $contents = Content::publishedByType(ContentContentType::Place)->filter($request)->orderBy
        ('created_at','desc')
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
    public function show(string $slug): View
    {
        $content =  Content::publishedByType(ContentContentType::Place)->where('slug', $slug)->with('user')->firstOrFail();
        $nextContent= $content->nextPublishedByType(ContentContentType::Place);
        $postImages = null;

        $previousContent= $content->previousPublishedByType(ContentContentType::Place);
        return view('place.show', [
            'markdown' =>  Str::of($content->content)->markdown(),
            'page' => $content,
            'nextContent' => $nextContent? route('placeShow',  ['slug'=>$nextContent->slug]) : null,
            'previousContent' => $previousContent? route('placeShow',  ['slug'=>$previousContent->slug]) : null,
            'postImages' => $postImages
        ]);
    }
}