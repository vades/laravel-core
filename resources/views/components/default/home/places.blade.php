
    <x-ui.heading level="h2"
                  size="lg"
                  class="!text-center">{{__('app.nav.otherPlaces')}}</x-ui.heading>
    <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-4 lg:gap-3 2xl:grid-cols-6 xl:gap-4 my-8">
        @foreach($places as $item)
            @php($coverImage = !empty($item->cover_image_url) ? $item->cover_image_url : config('myapp.image.placeholder.place'))

            <x-ui.my-card>
                <x-slot name="header">
                    <img class="w-full h-64 object-cover mb-4 rounded-t-sm"
                         src="{{asset($coverImage)}}"
                         alt="{{ $item->title}}">
                </x-slot>
                <x-slot name="body">

                    <h2 class="text-center text-lg font-bold">
                        <a href="{{ route('placeShow',  ['slug'=>$item->slug]) }}">{{ $item->title }} </a></h2>
                </x-slot>
                <x-slot name="footer">
                    <a href="{{ route('placeShow',  ['slug'=>$item->slug]) }}"
                                 class="btn btn-outline btn-primary my-btn-raquo">{>{{__('app.nav.readMore')}}</a>
                </x-slot>
            </x-ui.my-card>

        @endforeach
    </div>
    <div class="text-center">
        <a href="{{ route('placeIndex') }}"
                     class="btn btn-outline btn-primary my-btn-raquo">{>{{__('app.nav.allPlaces')}}</a>
    </div>
