<div class="my-card-featured">
    <figure>
        <img src="{{$src}}" alt="{{ $title }}">

        @if(!empty($title))
            <figcaption>{{ $title}}</figcaption>
        @endif
    </figure>
</div>
