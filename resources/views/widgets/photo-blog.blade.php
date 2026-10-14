<x-ui.my-widget :widget="$widget">
    <div class="my-widget-photo-rendered-content">
        {!! $widget->rendered_content !!}
    </div>
    @foreach ($images as $index => $item)
        <div class="my-widget-photo-blog-item">
            @if (!empty($item->title))
                <h3>
                    {{ $item->title }}
                </h3>
            @endif
            <figure>
                <img src="{{ $item->src }}" alt="{{ $item->title }}">
                @if (!empty($item->title))
                    <figcaption>{{ $item->description }}</figcaption>
                @endif
            </figure>
        </div>
    @endforeach
</x-ui.my-widget>
