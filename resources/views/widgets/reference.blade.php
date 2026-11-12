@php
    $images = $references->pluck('featured_image_url');
@endphp

@if (count($images))
    <x-ui.my-widget :widget="$widget" :class="$options['class'] ?? ''">
        <x-ui.my-carousel :images="$images" />
    </x-ui.my-widget>
@endif
