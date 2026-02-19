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
    @foreach($tags as $tag)
        <a href="{{ route($routeName, ['tag' => $tag->name]) }}" class="inline-block mb-2 cursor-pointer">
            <x-ui.badge variant="outline"
                        size="lg"> {{ $tag->name }} ({{ $tag->contents_count }})
            </x-ui.badge>

        </a>

    @endforeach

</x-default.layout>