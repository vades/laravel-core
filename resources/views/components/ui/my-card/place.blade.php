<x-ui.my-card class="my-card my-card-place">
    <x-slot name="header">
        <img class="my-card-img"
             src="{{asset($coverImage)}}"
             alt="{{ $item->title}}">
    </x-slot>
    <x-slot name="body">
        <div class="my-card-title">
            <a href="{{ route('placeShow',  ['slug'=>$item->slug]) }}">{{ $item->title }} </a></div>
        @if (filled($item->subtitle))
            <div class="my-card-subtitle">{{ $item->subtitle }}</div>
        @endif

        <div class="my-card-excerpt">
            {{ $item->excerpt }}
        </div>
    </x-slot>
    <x-slot name="footer">
        <a href="{{ route('placeShow',  ['slug'=>$item->slug]) }}" class="btn btn-outline btn-primary my-btn-raquo">{{__('app.nav.readMore')}}</a>
    </x-slot>
</x-ui.my-card>
