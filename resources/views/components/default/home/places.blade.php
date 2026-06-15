
    <h2>{{__('app.nav.otherPlaces')}}</h2>
    <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-4 lg:gap-3 2xl:grid-cols-6 xl:gap-4 my-8 my-grid-place">
        @foreach($places as $item)
            @php($coverImage = !empty($item->cover_image_url) ? $item->cover_image_url : config('myapp.image.placeholder.place'))

            <x-ui.my-card.place :item="$item" :coverImage="$coverImage" />

        @endforeach
    </div>
    <div class="text-center">
        <a href="{{ route('placeIndex') }}"
                     class="btn btn-wide btn-ghost btn-primary my-btn-raquo">{{__('app.nav.allPlaces')}}</a>
    </div>
