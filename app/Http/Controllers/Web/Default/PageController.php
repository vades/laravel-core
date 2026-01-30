<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $slug): View
    {
        $post = Post::publishedByType('page')->where('slug', $slug)->firstOrFail();
        $page =  (object)[
            'title' => $post->title,
            'subtitle' => $post->subtitle,
            'slug' => $post->slug,
            'description' =>  $post->description,
            'content' => Str::of( $post->content)->markdown(),
            'metaTitle' => $post->meta_title ?? $post->title,
            'keywords' =>  $post->keywords ?? '',
            'metaDescription' => $post->meta_description ?? $post->description,
            'imageUrl' => !empty($post->image_url) ? asset($post->image_url) : null,
        ];
        return view('components.web.' . config('myapp.project') . '.features.page.page-item',[
            'page' => $page]);
    }
}