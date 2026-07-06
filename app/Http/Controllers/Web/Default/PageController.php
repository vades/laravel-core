<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
use App\Http\Controllers\Controller;
use App\Queries\ContentQuery;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $slug): View
    {
        $query = new ContentQuery(ContentContentType::Page);
        return view('page.index', [
            'page' => $query->findBySlug($slug),
        ]);
    }
}