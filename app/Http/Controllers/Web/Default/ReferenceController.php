<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Queries\AlbumQuery;
use App\Queries\ContentQuery;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {

        $query = new ContentQuery(ContentContentType::Reference);


        return view(
            'reference.index',
            [
                'page'     => $query->meta(basename($request->path())),
                'contents' => $query->filtered(),
            ]
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(string $slug): View
    {
        $query   = new ContentQuery(ContentContentType::Reference);
        $content = $query->findBySlug($slug);

        $next     = $content->nextPublishedByType(ContentContentType::Reference);
        $previous = $content->previousPublishedByType(ContentContentType::Reference);

       return view('reference.show', [
            'page'            => $content,
            'nextContent'     => $next     ? route('articleShow', ['slug' => $next->slug])     : null,
            'previousContent' => $previous ? route('articleShow', ['slug' => $previous->slug]) : null
        ]);
    }
}
