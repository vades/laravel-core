<h2>{{__('app.nav.photoGallery')}}</h2>

<div class="grid grid-cols-1 gap-2  sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 my-4 my-grid-gallery">
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
    <a href="{{ route('photoGalleryIndex') }}"
                 class="btn btn-outline btn-primary my-btn-raquo">{>{{__('app.nav.allImages')}}</a>
</div>
