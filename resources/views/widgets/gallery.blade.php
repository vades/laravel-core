<x-ui.my-widget :widget="$widget" :class="$options['class'] ?? ''">
    {!! $widget->rendered_content !!}
    <x-ui.my-lightbox :images="$images" />
</x-ui.my-widget>
