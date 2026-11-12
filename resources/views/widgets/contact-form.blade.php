<x-ui.my-widget :widget="$widget" :class="$options['class'] ?? ''">
    {!! $widget->rendered_content !!}

    <livewire:widgets.contact-form />
</x-ui.my-widget>
