@inject('carbon', 'Carbon\Carbon')
<x-default.layout :title="$page->metaTitle"
                  :description="$page->metaDescription"
                  :keywords="$page->keywords">
    <x-slot name="jumbotron">
        <x-shared.jumbotron>
            <x-shared.page-header class="text-skin-blog">
                <x-slot name="image">
                    <img class="md:max-w-xs border-4 border-skin-muted drop-shadow-lg"
                         src="{{$content->image_url}}"
                         alt="{{ $content->title }}">
                </x-slot>
                <x-slot name="title" class="text-skin-blog">
                    {{ $content->title }}
                </x-slot>
                <x-slot name="subtitle">
                    {{ $content->subTitle ?? null }}
                </x-slot>
                <x-slot name="description">
                    {{ $content->description ?? null }}
                </x-slot>
                <x-slot name="info">
                    <span class="mr-2">{{$content->user->name}}</span>
                    <span class="posts-date">{{ $carbon::parse($content->createdAt)->format('Y-m-d') }}</span>
                </x-slot>
            </x-shared.page-header>
        </x-shared.jumbotron>
    </x-slot>
    <article class="text-skin-blog">
        {!! $markdown !!}
    </article>
    @if($content->tags->isNotEmpty())
        <section class="mt-4 flex gap-2 flex-wrap">
            @foreach($content->tags as $tag)
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