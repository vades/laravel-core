<div class="my-widget my-widget-default">

    @if ($widget->has_header)
        <header>
            @if ($widget->has_icon)
                <x-ui.my-img-svg img="{{ $widget->has_icon }}" classList="my-widget-icon" />
            @endif
            {{ $widget->title }}
        </header>
    @endif

    <div class="my-widget-body">{!! $widget->rendered_content !!}</div>

    @if ($widget->has_footer)
        <footer>{{ $widget->footer }}</footer>
    @endif
</div>
