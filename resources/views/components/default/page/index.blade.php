
@php
    if(isset($page->user)){
        $page->user = null;
    }
@endphp
<x-default.layout :title="$page->metaTitle ?? $page->title"
                  :description="$page->metaDescription ?? $page->excerpt"
                  :keywords="$page->keywords">
    <x-slot name="jumbotron">
        <x-ui.my-jumbotron>
            <x-default.partials.page-header :page="$page" />
        </x-ui.my-jumbotron>
    </x-slot>

    @if(!empty($page->featured_image_url))
        <figure>
            <img src="{{asset($page->featured_image_url)}}"
                 alt="{{ $page->title }}">
            <figcaption>The Alps in early winter.</figcaption>
        </figure>
    @endif
    <div class="content-container">
    <div class="content-wrapper">
        {!! $page->renderedContent !!}
    </div>
    @if(!empty($page->livewireWidget) && $page->livewireWidget === 'contact-form')
    <livewire:widgets.contact-form />
    @endif
    </div>
</x-default.layout>
