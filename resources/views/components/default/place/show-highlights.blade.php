@props(['highlights'])
<ul class="list my-list lg:grid gap-4  lg:grid-cols-2">
    @foreach($highlights as $item)
        @php($coverImage = !empty($item->cover_image_url) ? $item->cover_image_url : config('myapp.image.placeholder.place'))
        <li class="list-row my-list-row-highlight">
            <div>
                <img class="my-list-img"  src="{{asset($coverImage)}}" alt="{{ $item->title}}"/>
            </div>
            <div>
                <div class="my-list-title" ><a href="{{ route('placeShow',  ['slug'=>$item->slug]) }}">{{ $item->title }}</a></div>
                @if (filled($item->subtitle))
                <div class="my-list-subtitle">{{ $item->subtitle }}</div>
                @endif
                @if (filled($item->excerpt ))
                <div class="my-excerpt">{{ $item->excerpt }}</div>
                @endif
            </div>
            <a class="btn btn-square btn-ghost" href="{{ route('placeShow',  ['slug'=>$item->slug]) }}">
                <x-ui.my-img-svg img="circle-chevron-right" classList="my-icon"/>
            </a>
        </li>
    @endforeach
</ul>
