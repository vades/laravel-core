
    <x-ui.heading level="h2"
                  size="lg"
                  class="!text-center">{{__('app.nav.photoGallery')}}</x-ui.heading>

    <div class="grid grid-cols-1 gap-2  sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 my-4">
        @foreach($images as  $image)
            <a href="{{route('photoGalleryIndex')}}" class="overflow-hidden rounded-md">
                    <x-ui.my-card.gallery :src="$image->src"
                                          :alt="$image->title"
                    />
            </a>
        @endforeach
    </div>