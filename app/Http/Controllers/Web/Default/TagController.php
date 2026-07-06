<?php

namespace App\Http\Controllers\Web\Default;

use App\Http\Controllers\Controller;
use App\Queries\ContentQuery;
use App\Queries\TagQuery;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller
{

    public function index(Request $request): View
    {
        $contentType = basename($request->path());
        $query = new TagQuery($contentType);
        return view('tag.index', [
            'page' => (new ContentQuery)->meta('tags-'. $contentType),
            'tags' =>  $query->all(),
            'routeName' => $contentType . 'Index',
        ]);
    }
}