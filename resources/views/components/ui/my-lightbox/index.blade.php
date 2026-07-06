@props(['images'])
@props(['title'])
@isset($images)
    <section x-data="modalControl"
             @keydown.window="closeModalOnEscape($event)">
        <section x-data="{ activeIndex: 0, items: $el.querySelectorAll('[data-carousel-item]'), showLightbox: true }"
                 x-init="items[0].classList.remove('hidden')">
            <div class="hidden sm:block">
                <x-ui.my-modal class="dark">
                    <x-slot name="title">
                        {{$title ??''}}
                    </x-slot>
                    <x-slot name="body">
                        <article {{$attributes->class(['flex items-center gap-4 h-[75%]'])}} x-show="showLightbox">
                            <div class="w-20 h-full">
                                <button type="button"
                                        class="flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                        data-carousel-prev
                                        @click="items[activeIndex].classList.add('hidden'); activeIndex = (activeIndex - 1 + items.length) % items.length; items[activeIndex].classList.remove('hidden')">
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-800/30 group-hover:bg-gray-800/60 group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180"
                 aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 6 10">
                <path stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 1 1 5l4 4" />
            </svg>
            <span class="sr-only">Previous</span>
        </span>
                                </button>
                            </div>
                            <div class="flex-1 flex items-center justify-center">

                                @foreach($images as $item)
                                    <figure class="hidden duration-700 ease-in-out"
                                            data-carousel-item
                                            @click="items[activeIndex].classList.add('hidden'); activeIndex = (activeIndex + 1) % items.length; items[activeIndex].classList.remove('hidden')">
                                        <img src="{{$item->src}}"
                                             class="max-w-full max-h-[80vh]"
                                             alt="{{ $item->title}}">
                                        <figcaption class="mt-4 text-gray-900 dark:text-gray-400">{{ $item->title}}</figcaption>
                                    </figure>

                                @endforeach

                            </div>
                            <div class="w-20 h-full">
                                <button type="button"
                                        class="flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                        data-carousel-next
                                        @click="items[activeIndex].classList.add('hidden'); activeIndex = (activeIndex + 1) % items.length; items[activeIndex].classList.remove('hidden')">
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-800/30 group-hover:bg-gray-800/60 group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180"
                 aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 6 10">
                <path stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="m1 9 4-4-4-4" />
            </svg>
            <span class="sr-only">Next</span>
        </span>
                                </button>
                                {{--   <button type="button" @click="items[activeIndex].classList.add('hidden'); activeIndex = (activeIndex + 1) % items.length; items[activeIndex].classList.remove('hidden')">Next</button>  --}}
                            </div>
                        </article>
                    </x-slot>
                    {{--  <x-slot name="footer">
                         <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition"
                                 @click="closeModal()">Close (ESC)
                         </button>
                     </x-slot> --}}
                </x-ui.my-modal>
            </div>

            <div class="grid grid-cols-1 gap-2  sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 my-4">
                @foreach($images as $index => $item)
                    <x-ui.my-card.gallery :src="$item->src"
                                          :alt="$item->title"
                                          @click="openModal(), showLightbox = true, items[activeIndex].classList.add('hidden'); activeIndex = {{ $index }}; items[activeIndex].classList.remove('hidden')"
                    />
                @endforeach
            </div>


        </section>
    </section>
@endisset
