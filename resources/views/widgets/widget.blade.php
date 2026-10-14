<div class="my-widget my-widget-default">

    <header>
        @if ($widget->has_icon)
            <x-ui.my-img-svg img="{{ $widget->has_icon }}" classList="my-widget-icon" />
        @endif
        {{ $widget->title }} {{ $widget->has_icon }}
    </header>
    <div class="my-widget-body"> {!! $widget->rendered_content !!}</div>

    <footer>{{ $widget->footer }}</footer>
</div>
