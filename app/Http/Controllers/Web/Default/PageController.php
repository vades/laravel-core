<?php

namespace App\Http\Controllers\Web\Default;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $slug): View
    {
        $content = Content::publishedByType('page')->where('slug', $slug)->firstOrFail();
        $page =  (object)[
            'title' => $content->title,
            'subtitle' => $content->subtitle,
            'slug' => $content->slug,
            'description' =>  $content->description,
            'content' => Str::of( $content->content)->markdown(),
            'metaTitle' => $content->meta_title ?? $content->title,
            'keywords' =>  $content->keywords ?? '',
            'metaDescription' => $content->meta_description ?? $content->description,
            'imageUrl' => !empty($content->image_url) ? asset($content->image_url) : null,
        ];
        return view('components.web.' . config('myapp.project') . '.features.page.page-item',[
            'page' => $page]);
    }
}