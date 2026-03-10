@props(['related'])
<section {{$attributes->class(['md:grid md:grid-cols-2 md:gap-4'])}}>
    @foreach($related as $item)
        <a class="text-skin-place" href="{{ route('placeShow',  ['slug'=>$item->slug]) }}">
            <x-ui.my-panel class="bg-skin-place place-card">
                <x-slot name="header">
                    <figure class="mb-3 md:mr-3">
                        <img class="mr-auto ml-auto has-transition" src="{{$item->image_url}}"
                             alt="{{ $item->title}}">
                    </figure>

                </x-slot>
                <x-slot name="body"
                        class="p-3">
                    <h3 class="text-lg mb-3">{{ $item->title }}</h3>
                    <div class="mb-3">{{ $item->description }}</div>
                </x-slot>
            </x-ui.my-panel>
        </a>
    @endforeach
</section>