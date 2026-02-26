
<x-default.layout :title="$page->metaTitle"
                  :description="$page->metaDescription"
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
    <div class="mb-8">
        {!! $markdown !!}
    </div>
    @if($page->tags->isNotEmpty())
        <x-ui.heading level="h2"> Tags</x-ui.heading>
        <section class="mt-4 flex gap-2 flex-wrap">

            @foreach($page->tags as $tag)
                <a href="{{ route('articleIndex', ['tag' => $tag->name]) }}">
                    <x-ui.badge variant="outline"
                                size="lg"> {{ $tag->name }}
                    </x-ui.badge>
                </a>
            @endforeach
        </section>
    @endif
    <section>
        <x-ui.my-prev-next class="flex justify-center mt-8" :prevUrl="$previousContent" :nextUrl="$nextContent"/>

    </section>
</x-default.layout>