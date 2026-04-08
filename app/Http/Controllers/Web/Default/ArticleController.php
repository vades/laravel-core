<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Queries\ContentQuery;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = new ContentQuery(ContentContentType::Article);

        return view('article.index', [
            'page'     => $query->meta(basename($request->path())),
            'contents' => $query->paginated(),
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $slug): View
    {

        $query   = new ContentQuery(ContentContentType::Article);
        $content = $query->findBySlug($slug, ['user']);

        $next     = $content->nextPublishedByType(ContentContentType::Article);
        $previous = $content->previousPublishedByType(ContentContentType::Article);

        $viewMode = $content['viewMode'] ?? 'default';

        return view('article.show-' .$viewMode, [
            'page'            => $content,
            'nextContent'     => $next     ? route('articleShow', ['slug' => $next->slug])     : null,
            'previousContent' => $previous ? route('articleShow', ['slug' => $previous->slug]) : null,
            'postImages'      => $query->postImages($content),
        ]);
    }
}