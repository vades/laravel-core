@php
    if (isset($page->user)) {
        $page->user = null;
    }
@endphp
<x-default.layout :title="$page->metaTitle ?? $page->title" :description="$page->metaDescription ?? $page->excerpt" :keywords="$page->keywords">
    <x-slot name="jumbotron">
        <x-ui.my-jumbotron>
            <x-default.partials.page-header :page="$page" />
        </x-ui.my-jumbotron>
    </x-slot>
    @if (!empty($page->featured_image_url))
        <figure class="my-featured-image-container">
            <img class="my-featured-image" src="{{ asset($page->featured_image_url) }}" alt="{{ $page->title }}">
            {{--  <figcaption>The Alps in early winter.</figcaption> --}}
        </figure>
    @endif
    <div class="content-container">
        <div class="content-wrapper">
            {!! $page->renderedContent !!}
        </div>

    </div>
    @if ($contents->isNotEmpty())
        <section class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3 lg:gap-3 2xl:grid-cols-4 xl:gap-4 my-grid-article">
            @foreach ($contents as $item)
                <x-ui.my-card.reference :item="$item" :featuredImage="$item->featured_image_url ?: config('myapp.image.placeholder.reference')" />
            @endforeach
        </section>

        @if ($contents->hasPages())
            <section class="flex justify-center mt-8">
                {{ $contents->links() }}
            </section>
        @endif
    @endif
</x-default.layout>
