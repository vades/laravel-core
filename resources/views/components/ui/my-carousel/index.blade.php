@props(['images' => [], 'height' => 'h-72'])

<div x-data="{
    current: 0,
    images: @js($images),
    next() { this.current = (this.current + 1) % this.images.length },
    prev() { this.current = (this.current - 1 + this.images.length) % this.images.length },
}" class="relative w-full {{ $height }} overflow-hidden rounded-lg">
    {{-- Slides --}}
    <div class="flex h-full w-full transition-transform duration-500 ease-in-out"
        :style="`transform: translateX(-${current * 100}%)`">
        <template x-for="(image, index) in images" :key="index">
            <div class="h-full w-full min-w-full shrink-0 basis-full">
                <img :src="image" :alt="`Slide ${index + 1}`" class="block h-full w-full object-cover">
            </div>
        </template>
    </div>

    {{-- Previous button --}}
    <button type="button" @click="prev()" aria-label="Previous slide"
        class="absolute left-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center cursor-pointer rounded-full bg-white/80 text-gray-800 shadow hover:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    {{-- Next button --}}
    <button type="button" @click="next()" aria-label="Next slide"
        class="absolute right-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center cursor-pointer rounded-full bg-white/80 text-gray-800 shadow hover:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
    </button>
</div>
