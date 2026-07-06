
    <h2>{{__('app.nav.bestPlacesToVisitIn',['name'=>'Nuremberg'])}}</h2>
    <div class="md:grid  gap-2 md:grid-cols-2 lg:grid-cols-3  my-8 my-grid-featured">
        @foreach($placesFeatured as  $item)
            @php($coverImage = !empty($item->featured_image_url) ? $item->featured_image_url : config('myapp.image.placeholder.place'))
            <a href="{{ route('placeShow',  ['slug'=>$item->slug]) }}" title="{{$item->excerpt}}"
               class="overflow-hidden rounded-md">
                <x-ui.my-card.featured src="{{asset($coverImage)}}"
                                       :title="$item->title"
                />
            </a>
        @endforeach
    </div>
