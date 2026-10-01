<div class="card my-home-feature">

    <div class="card-body">
        @if($widget->has_icon)
            <x-ui.my-img-svg img="{{ $widget->has_icon }}" classList="my-icon" />
        @endif

        <h2 class="card-title">{{ $widget->title }}</h2>
        <div>{!! $widget->rendered_content !!}</div>

        @if(!empty($widget->footer))
            <div class="card-actions">
                @foreach(array_filter(array_map('trim', explode('|', $widget->footer))) as $badge)
                    <span class="my-badge">{{ $badge }}</span>
                @endforeach
            </div>
        @endif
    </div>
</div>