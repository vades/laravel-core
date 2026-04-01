
<x-default.layout :title="$page->metaTitle ?? $page->title"
                  :description="$page->metaDescription ?? $page->excerpt"
                  :keywords="$page->keywords">
    <x-slot name="jumbotron">
        <x-ui.my-jumbotron>
            <x-default.partials.page-header :page="$page" />
        </x-ui.my-jumbotron>
    </x-slot>

    @if(!empty($page->featured_image_url))
        <figure>
            <img src="{{asset($page->featured_image_url)}}"
                 alt="{{ $page->title }}">
           {{--  <figcaption>The Alps in early winter.</figcaption> --}}
        </figure>
    @endif
    <div class="content-wrapper">
        {!! $markdown !!}
    </div>
    @if($page->tags->isNotEmpty())
        <x-ui.heading level="h2" class="mb-4"> {{__('app.nav.tags')}}</x-ui.heading>
        <section class="grid gap-2 sm:grid-cols-2 md:grid-cols-4 lg:inline-flex lg:flex-wrap">

            @foreach($page->tags as $tag)
                <a href="{{ route('articleIndex', ['tag' => $tag->name]) }}" class="cursor-pointer group mb-2 sm:mb-0">
                    <x-ui.badge variant="outline"
                                size="lg" class="w-full justify-center lg:w-auto transition-all duration-200 group-hover:scale-105 whitespace-normal break-words text-center"> {{ $tag->name }}
                    </x-ui.badge>
                </a>
            @endforeach
        </section>
    @endif
    <section>
        <x-ui.my-prev-next class="flex justify-center mt-8" :prevUrl="$previousContent" :nextUrl="$nextContent"/>

    </section>
</x-default.layout>