@props(['images' => [], 'height' => 'h-72'])

@php
    $slideCount = count($images);
@endphp

@if ($slideCount > 1)
    <div x-data="{ current: 0 }" class="relative w-full {{ $height }} overflow-hidden rounded-lg">
        @foreach ($images as $index => $image)
            @php
                $slug = data_get($image, 'slug');
                $title = data_get($image, 'title');
                $imageUrl = data_get($image, 'featured_image_url');
            @endphp

            <div
                x-show="current === {{ $index }}"
                class="absolute inset-0 h-full w-full"
            >
                <a
                    href="{{ route('referenceShow', ['slug' => $slug]) }}"
                    class="relative block h-full w-full"
                >
                    <img
                        src="{{ $imageUrl }}"
                        alt="{{ $title }}"
                        class="block h-full w-full object-cover"
                    >
                    <span class="absolute inset-x-0 bottom-0 bg-white/80 px-4 py-3 text-center text-gray-800">
                        {{ $title }}
                    </span>
                </a>
            </div>
        @endforeach

        <button
            type="button"
            @click="current = (current - 1 + {{ $slideCount }}) % {{ $slideCount }}"
            aria-label="Previous slide"
            class="absolute left-3 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center cursor-pointer rounded-full bg-white/80 text-gray-800 shadow hover:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <button
            type="button"
            @click="current = (current + 1) % {{ $slideCount }}"
            aria-label="Next slide"
            class="absolute right-3 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center cursor-pointer rounded-full bg-white/80 text-gray-800 shadow hover:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
@endif
