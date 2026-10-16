@props(['widget' => null])
@if ($widget)
    <div class="my-widget my-widget-{{ $widget->content_type }} my-widget-slug-{{ $widget->slug }}">
        @if ($widget->has_header)
            <header>
                @if ($widget->has_icon)
                    <x-ui.my-img-svg img="{{ $widget->has_icon }}" classList="my-widget-icon" />
                @endif
                {{ $widget->title }}
            </header>
        @endif

        <div class="my-widget-body">{{ $slot }}</div>

        @if ($widget->has_footer)
            <footer>{{ $widget->footer }}</footer>
        @endif
    </div>
@else
    {{ $slot }}
@endif
