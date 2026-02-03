@inject('carbon', 'Carbon\Carbon')
<x-default.layout :title="$page->metaTitle"
                  :description="$page->metaDescription"
                  :keywords="$page->keywords">
    <x-slot name="jumbotron">
        <x-shared.jumbotron>
            <x-shared.page-header class="text-skin-blog">
                @if(empty($page->featured_image_url) && !empty($page->cover_image_url))
                    <x-slot name="image">
                        <img class="md:max-w-xs border-4 border-skin-muted drop-shadow-lg"
                             src="{{asset($page->cover_image_url)}}"
                             alt="{{ $page->title }}">
                    </x-slot>

                @endif

                <x-slot name="title" class="text-skin-blog">
                    {{ $page->title }}
                </x-slot>
                <x-slot name="subtitle">
                    {{ $page->subTitle ?? null }}
                </x-slot>
                <x-slot name="description">
                    {{ $page->excerpt ?? null }}
                </x-slot>
                <x-slot name="info">
                    <span class="mr-2">{{$page->user->name}}</span>
                    <span class="posts-date">{{ $carbon::parse($page->createdAt)->format('Y-m-d') }}</span>
                </x-slot>
            </x-shared.page-header>
        </x-shared.jumbotron>
    </x-slot>

    @if(!empty($page->featured_image_url))
        <figure>
            <img src="{{asset($page->featured_image_url)}}"
                 alt="{{ $page->title }}">
            <figcaption>The Alps in early winter.</figcaption>
        </figure>
    @endif
    <article class="text-skin-blog">
        {!! $markdown !!}
    </article>
    @if($page->tags->isNotEmpty())
        <section class="mt-4 flex gap-2 flex-wrap">
            @foreach($page->tags as $tag)
                <a href="{{ route('articleTagList', ['tag' => $tag->slug]) }}">
                    <x-shared.badge>{{ $tag->name }}</x-shared.badge>
                </a>
            @endforeach
        </section>
    @endif
    <section>
        <x-shared.prev-next class="flex justify-center mt-8" :prevUrl="$previousContent" :nextUrl="$nextContent"/>

    </section>
</x-default.layout>