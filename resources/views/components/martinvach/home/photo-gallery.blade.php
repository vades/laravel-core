<x-ui.heading level="h2"
              size="lg"
              class="!text-center">{{__('app.nav.photoGallery')}}</x-ui.heading>

<div class="grid grid-cols-1 gap-2  sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 mb-4">
    @foreach($images as  $item)
        <a href="{{route('photoGalleryIndex')}}"
           class="overflow-hidden rounded-md">
            <x-ui.my-card.gallery :src="$item->src"
                                  :alt="$item->title"
            />
        </a>
    @endforeach
</div>
<div class="text-center">
    <x-ui.button href="{{ route('photoGalleryIndex') }}"
                 variant="solid" size="lg"  iconAfter="chevron-right">{{__('app.nav.allImages')}}</x-ui.button>
</div>