<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Queries\ContentQuery;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {

        $query = new ContentQuery(ContentContentType::Service);

        return view(
            'reference.index',
            [
                'page'     => $query->meta(basename($request->path())),
                'contents' => $query->filtered(orderBy:['position','asc']),
            ]
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(string $slug): View
    {
        $query   = new ContentQuery(ContentContentType::Service);
        $content = $query->findBySlug($slug);
        $next     = $content->nextPublishedByType(ContentContentType::Service);
        $previous = $content->previousPublishedByType(ContentContentType::Service);

       return view('reference.show', [
            'page'            => $content,
            'references' => $query->latest(take: 6)->whereNotIn('slug', [$slug])->sortByDesc('position'),
            'nextContent'     => $next     ? route('referenceShow', ['slug' => $next->slug])     : null,
            'previousContent' => $previous ? route('referenceShow', ['slug' => $previous->slug]) : null
        ]);
    }
}
