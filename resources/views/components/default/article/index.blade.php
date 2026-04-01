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
            <x-default.partials.page-header :page="$page" />
        </x-ui.my-jumbotron>
    </x-slot>
    <section class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3 lg:gap-3 2xl:grid-cols-4 xl:gap-4">
        @foreach($contents as $item)
            @php($coverImage = !empty($item->cover_image_url) ? $item->cover_image_url : config('myapp.image.placeholder.article'))

            <x-ui.my-card.article :item="$item" :coverImage="$coverImage" />


        @endforeach
    </section>
    <section class="flex justify-center mt-8">
        {!! $contents->links() !!}

        {{-- <x-utils.pagination class="flex justify-center mt-8" /> --}}
    </section>
</x-default.layout>