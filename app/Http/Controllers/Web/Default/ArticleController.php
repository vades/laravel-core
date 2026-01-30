<?php

namespace App\Http\Controllers\Web\Default;

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
        $contents = Content::publishedByType()->filter($request)->orderBy('created_at','desc')
                     ->paginate(20);
        $page = (object)[
            'title' =>__('blogList'),
            'subtitle' => null,
            'metaTitle' => 'Blog List - Page Meta Title',
            'keywords' => 'Blog, List, ,Page, keywords',
            'metaDescription' => 'Blog List - Page meta description',
        ];

        return view(
            'components.web.' . config('myapp.project') . '.features.blog.blog-list',
            [
                'contents' => $contents,
                'page' => $page
            ]
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $content =  Content::publishedByType()->where('slug', $id)->with('user')->firstOrFail();
        $nextContent= $content->nextPublishedByType('post');
        $viewMode=$content['viewMode'];
        $postImages = null;
    /*    if($content['eventDirectory'] !== null){
            $postImages = collect(AlbumService::fetchPostImages())->where('directory', $content['eventDirectory'])->values()
                                                                  ->toArray();
        }*/

        $previousContent= $content->previousPublishedByType('post');
        $page = (object)[
            'title' => $content['title'],
            'subtitle' => $content['subTitle'],
            'metaTitle' => $content['metaTitle'],
            'keywords' => $content['keywords'] ?? null,
            'metaDescription' => $content['metaDescription'],
        ];
        return view('components.web.' . config('myapp.project') . '.features.blog.blog-item-' .$viewMode, [
            'post' =>  (object)$content,
            'content' =>  Str::of($content->content)->markdown(),
            'page' => $page,
            'nextPost' => $nextContent? route('blogItem',  ['postId'=>$nextContent->slug]) : null,
            'previousPost' => $previousContent? route('blogItem',  ['postId'=>$previousContent->slug]) : null,
            'postImages' => $postImages
        ]);
    }

    public function category()
    {
        $categories = Category::publishedByType()->withCount('contents')->where('posts_count','>',0)->get();
        $page = (object)[
            'title' => 'Blog Category title',
            'subtitle' => 'Blog Category subtitle',
            'metaTitle' => 'Blog Category - Page Meta Title',
            'keywords' => 'Blog, Category, Page, keywords',
            'metaDescription' => 'Blog Category - Page meta description',
        ];

        return view('components.web.' . config('myapp.project') . '.features.blog.blog-list-category',  [
            'categories' => $categories,
            'page' => $page

        ]);
    }

    public function tag()
    {
        $tags = Tag::publishedByType()->withCount('contents')->where('posts_count','>',0)->get();
        $page = (object)[
            'title' => 'Blog Tag title',
            'subtitle' => 'Blog Tag subtitle',
            'metaTitle' => 'Blog Tag - Page Meta Title',
            'keywords' => 'Blog, Tag, Page, keywords',
            'metaDescription' => 'Blog Tag - Page meta description',
        ];
        return view('components.web.features' . config('myapp.project') . 'blog.blog-list-tag', [
            'page' => $page,
            'tags' => $tags
        ]);
    }
}