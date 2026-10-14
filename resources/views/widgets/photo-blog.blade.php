<div class="my-widget my-widget-photo-blog">
    @foreach ($images as $index => $item)
        @if (!empty($item->title))
            <header>
                {{ $item->title }}
            </header>
        @endif
        <figure>
            <img src="{{ $item->src }}" alt="{{ $item->title }}">
            @if (!empty($item->title))
                <figcaption>{{ $item->title }}</figcaption>
            @endif
        </figure>
    @endforeach
</div>
