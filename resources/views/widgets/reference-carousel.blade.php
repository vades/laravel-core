@if ($references->count() > 1)
    <x-ui.my-widget :widget="$widget" :class="$options['class'] ?? ''">
        <x-ui.my-carousel :images="$references" />
    </x-ui.my-widget>
@endif
