
@php
    if(isset($page->user)){
        $page->user = null;
    }
@endphp
<x-default.layout :title="$page->metaTitle"
                  :description="$page->metaDescription"
                  :keywords="$page->keywords">
    <x-slot name="jumbotron">
        <x-shared.jumbotron>
            <x-default.partials.page-header :page="$page" />
        </x-shared.jumbotron>
    </x-slot>

    @if(!empty($page->featured_image_url))
        <figure>
            <img src="{{asset($page->featured_image_url)}}"
                 alt="{{ $page->title }}">
            <figcaption>The Alps in early winter.</figcaption>
        </figure>
    @endif
    <div class="content-wrapper">
        {!! $renderedBody !!}
    </div>
</x-default.layout>