<x-ui.my-card class="my-card my-card-place">
    <x-slot name="header">
        <a href="{{ route('placeShow', ['slug' => $item->slug]) }}">
            <img class="my-card-img" src="{{ asset($coverImage) }}" alt="{{ $item->title }}"></a>
    </x-slot>
    <x-slot name="body">
        <div class="my-card-title">
            <a href="{{ route('placeShow', ['slug' => $item->slug]) }}">{{ $item->title }} </a>
        </div>
        @if (filled($item->subtitle))
            <div class="my-card-subtitle">{{ $item->subtitle }}</div>
        @endif
        @if (filled($item->excerpt))
            <div class="my-card-excerpt">
                {{ $item->excerpt }}
            </div>
        @endif
    </x-slot>
    <x-slot name="footer">
        <a href="{{ route('placeShow', ['slug' => $item->slug]) }}"
            class="btn btn-ghost my-btn-raquo">{{ __('app.nav.readMore') }}</a>
    </x-slot>
</x-ui.my-card>
