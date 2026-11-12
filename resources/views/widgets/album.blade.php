<x-ui.my-widget :widget="$widget" :class="$options['class'] ?? ''">
    {!! $widget->rendered_content !!}
</x-ui.my-widget>
