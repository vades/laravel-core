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
            @php($coverImage = !empty($item->cover_image_url) ? $item->cover_image_url : config('myapp.image.placeholder.place'))

                <x-ui.my-card>
                    <x-slot name="header">
                        <img class="w-full h-64 object-cover mb-4 rounded-t-sm"
                             src="{{asset($coverImage)}}"
                             alt="{{ $item->title}}">
                    </x-slot>
                    <x-slot name="body">

                        <h2 class="text-2xl font-bold mb-2">  <a href="{{ route('placeShow',  ['slug'=>$item->slug]) }}">{{ $item->title }} </a></h2>

                        <div class="card-excerpt">
                            {{ $item->excerpt }}
                        </div>
                    </x-slot>
                    <x-slot name="footer">
                        <x-ui.button href="{{ route('placeShow',  ['slug'=>$item->slug]) }}" variant="outline" class="after:content-['\203A'] after:ml-2 rtl:after:rotate-180">{{__('app.nav.readMore')}}</x-ui.button>
                    </x-slot>
                </x-ui.my-card>


        @endforeach
    </section>
    <section class="flex justify-center mt-8">
        {!! $contents->links() !!}

        {{-- <x-utils.pagination class="flex justify-center mt-8" /> --}}
    </section>
</x-default.layout>