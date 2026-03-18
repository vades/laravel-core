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
            <x-default.partials.page-header :page="$page" />
        </x-ui.my-jumbotron>
    </x-slot>
    <div class="grid grid-cols-1 gap-4  sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 my-4">
        @foreach($images as $item)
            <a href="{{route('photoGalleryShow',['slug' =>$item->directory])}}">
                <x-ui.my-card.gallery :src="$item->src"
                                      :alt="$item->title"
                                      :title="$item->title"
                />
            </a>
        @endforeach
    </div>
</x-default.layout>