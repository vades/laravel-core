@php
    if(isset($page->user)){
        $page->user = null;
    }
@endphp
<x-default.layout :title="$page->metaTitle"
                  :description="$page->metaDescription"
                  :keywords="$page->keywords">
    <x-slot name="jumbotron">
        <x-ui.my-jumbotron>
            <x-default.place.show-header :page="$page" />
        </x-ui.my-jumbotron>
    </x-slot>

    @if(!empty($images))
        <x-ui.my-lightbox :images="$images"/>
    @endif
    @if(!empty($markdown))
    <div class="mb-8">
        {!! $markdown !!}
    </div>
    @endif

    @if(count($highlights) > 0)
        <h2 class="text-lg mb-4 max-sm:text-center">{{ $page->title }} highlights</h2>
        <x-default.place.show-highlights :highlights="$highlights" class="mb-8 text-skin-place" />
    @endif

    @if(count($related) > 0)
        <h2 class="max-sm:text-center">Other places in category</h2>
        <x-default.place.show-related :related="$related" class="mb-8 text-skin-place" />
    @endif
    <section>
        <x-ui.my-prev-next class="flex justify-center mt-8" :prevUrl="$previousContent" :nextUrl="$nextContent"/>

    </section>
</x-default.layout>