@php
    if(isset($page->user)){
        $page->user = null;
    }
@endphp
<x-default.layout :title="$page->metaTitle ?? $page->title"
                  :description="$page->metaDescription ?? $page->excerpt"
                  :keywords="$page->keywords">
    <x-slot name="jumbotron">
        <x-ui.my-jumbotron>
            <x-default.place.show-header :page="$page" />
        </x-ui.my-jumbotron>
    </x-slot>

    @if(!empty($images))
        <x-ui.my-lightbox :images="$images" />
    @endif
    @if(!empty($markdown))
    <div class="content-wrapper">
        {!! $page->rendered_content !!}
    </div>
    @endif

    @if(count($highlights) > 0)
        <h2>{{ $page->title }} {{__('app.label.highlights') }}</h2>
        <x-default.place.show-highlights :highlights="$highlights" class="my-4" />
    @endif

    @if(count($related) > 0)
        <h2>{{__('app.label.relatedPlaces')}} </h2>
        <x-default.place.show-related :related="$related" class="my-4" />
    @endif
    <section>
        <x-ui.my-prev-next class="flex justify-center mt-8" :prevUrl="$previousContent" :nextUrl="$nextContent"/>

    </section>
</x-default.layout>
