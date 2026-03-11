
@php
    if(isset($page->user)){
        $page->user = null;
    }
@endphp
<x-default.layout >
    <x-slot name="jumbotron">
        <x-ui.my-jumbotron>
            <x-default.partials.page-header :page="$page" />
        </x-ui.my-jumbotron>
    </x-slot>

    @if(!empty($images))
        <x-ui.my-lightbox :images="$images" />
    @endif
</x-default.layout>