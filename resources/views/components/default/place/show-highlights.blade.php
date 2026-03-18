@props(['highlights'])
<section {{$attributes->class(['grid grid-cols-2 gap-2 md:grid-cols-6 lg:grid-cols-8'])}}>
    @foreach($highlights as $item)
        @php($coverImage = !empty($item->cover_image_url) ? $item->cover_image_url : config('myapp.image.placeholder.place'))
        <a class="text-skin-place" href="{{ route('placeShow',  ['slug'=>$item->slug]) }}">
            <x-ui.my-card class="bg-skin-place place-card">
                <x-slot name="header">
                    <img class="mr-auto ml-auto has-transition"
                         src="{{asset($coverImage)}}"
                         alt="{{ $item->title}}">
                </x-slot>
                <x-slot name="body"
                        class="p-2 text-center">
                    <h3 class="text-lg mb-3">{{ $item->title }}</h3>
                </x-slot>
            </x-ui.my-card>
        </a>
    @endforeach
</section>