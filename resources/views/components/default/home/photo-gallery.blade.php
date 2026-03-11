
    <x-ui.heading level="h2"
                  size="lg"
                  class="!text-center">{{__('app.nav.photoGallery')}}</x-ui.heading>

    <div class="grid grid-cols-1 gap-2  sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 my-4">
        @foreach($images as $index => $item)
            <a href="{{route('photoGalleryIndex')}}" class="overflow-hidden rounded-md">
                <img class="w-full aspect-square object-cover cursor-pointer
                                    transition-transform duration-300 ease-in-out hover:scale-110
                                    image-thumbnail"
                     src="{{$item->src}}"
                     alt="{{ $item->title}}"
                >
            </a>
        @endforeach
    </div>