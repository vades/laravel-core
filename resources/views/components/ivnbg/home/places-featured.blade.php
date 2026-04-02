
    <x-ui.heading level="h2"
                  size="lg"
                  class="!text-center mb-4">{{__('app.nav.bestPlacesToVisitIn',['name'=>'Nuremberg'])}}</x-ui.heading>
    <div class="md:grid  gap-2 md:grid-cols-2 lg:grid-cols-3">
        @foreach($places as $item)
            @php($coverImage = !empty($item->cover_image_url) ? $item->cover_image_url : config('myapp.image.placeholder.place'))
            <a href="{{ route('placeShow',  ['slug'=>$item->slug]) }}">
            <x-ui.my-card class="relative my-card-featured">
                <x-slot name="header" class="overflow-hidden">
                    <img class="w-full h-64 object-cover"
                         src="{{asset($coverImage)}}"
                         alt="{{ $item->title}}">
                </x-slot>
                <x-slot name="body" class="absolute bottom-0 left-0 right-0 p-2 bg-[rgba(255,255,255,0.8)]">

                    <h3 class="text-center text-lg font-bold">
                        {{ $item->title }} </h3>


                </x-slot>
            </x-ui.my-card>
            </a>
        @endforeach
    </div>