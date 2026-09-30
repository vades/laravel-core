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
    <section class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3 lg:gap-3 2xl:grid-cols-4 xl:gap-4 my-grid-article">
        @foreach($contents as $item)
            @php($featuredImage = !empty($item->featured_image_url) ? $item->featured_image_url : config('myapp.image.placeholder.reference'))

            <x-ui.my-card.reference :item="$item" :featuredImage="$featuredImage" />


        @endforeach
    </section>
    <section class="flex justify-center mt-8">
        {!! $contents->links() !!}
    </section>
</x-default.layout>
