<div {{$attributes->class(['my-card-gallery'])}}>
    <figure>
        <img src="{{$src}}" alt="{{ $alt ?? 'image'}}">

        @if(!empty($title))
            <figcaption>{{ $title}}</figcaption>
        @endif
    </figure>
</div>
