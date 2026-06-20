
    <h2>{{__('app.nav.bestPlacesToVisitIn',['name'=>'Nuremberg'])}}</h2>
    <div class="md:grid  gap-2 md:grid-cols-2 lg:grid-cols-3  my-8 my-grid-featured">
        @foreach($places as  $item)
            @php($coverImage = !empty($item->cover_image_url) ? $item->cover_image_url : config('myapp.image.placeholder.place'))
            <a href="{{route('photoGalleryIndex')}}" title="{{$item->excerpt}}"
               class="overflow-hidden rounded-md">
                <x-ui.my-card.featured src="{{asset($coverImage)}}"
                                       :title="$item->title"
                />
            </a>
        @endforeach
    </div>
