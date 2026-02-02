<?php

namespace App\Http\Controllers\Web\Default;

use App\Enums\ContentContentType;
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
            'article.index',
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
        //$content =  Content::publishedByType()->where('slug', $id)->firstOrFail();
        $nextContent= $content->nextPublishedByType(ContentContentType::Article);
        $viewMode=$content['viewMode'] ?? 'default';
        $postImages = null;
    /*    if($content['eventDirectory'] !== null){
            $postImages = collect(AlbumService::fetchPostImages())->where('directory', $content['eventDirectory'])->values()
                                                                  ->toArray();
        }*/

        $previousContent= $content->previousPublishedByType(ContentContentType::Article);
        $page = (object)[
            'title' => $content['title'],
            'subtitle' => $content['subTitle'],
            'metaTitle' => $content['metaTitle'],
            'keywords' => $content['keywords'] ?? null,
            'metaDescription' => $content['metaDescription'],
        ];
        return view('article.show-' .$viewMode, [
            'content' =>  $content,
            'markdown' =>  Str::of($content->content)->markdown(),
            'page' => $page,
            'nextContent' => $nextContent? route('articleShow',  ['slug'=>$nextContent->slug]) : null,
            'previousContent' => $previousContent? route('articleShow',  ['slug'=>$previousContent->slug]) : null,
            'postImages' => $postImages
        ]);
    }

    public function tag()
    {
        $tags = Tag::ByContentType()->withCount('contents')->where('contents_count','>',0)->get();
        $page = (object)[
            'title' => 'Blog Tag title',
            'subtitle' => 'Blog Tag subtitle',
            'metaTitle' => 'Blog Tag - Page Meta Title',
            'keywords' => 'Blog, Tag, Page, keywords',
            'metaDescription' => 'Blog Tag - Page meta description',
        ];
        return view('article.tags', [
            'page' => $page,
            'tags' => $tags
        ]);
    }
}