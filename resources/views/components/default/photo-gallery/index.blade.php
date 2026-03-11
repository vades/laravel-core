
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
    <div class="grid grid-cols-1 gap-2  sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 my-4">
    @foreach($images as $index => $item)
        <a href="{{route('photoGalleryShow',['slug' =>$item->directory])}}" class="overflow-hidden rounded-md">
            <img class="w-full aspect-square object-cover cursor-pointer
                                    transition-transform duration-300 ease-in-out hover:scale-110
                                    image-thumbnail"
                 src="{{$item->src}}"
                 alt="{{ $item->title}}"
                 >
                <figcaption class="mt-2 text-sm text-center">{{ $item->title}}</figcaption>
        </a>
    @endforeach
    </div>
</x-default.layout>