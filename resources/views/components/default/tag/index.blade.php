@php
    if(isset($page->user)){
        $page->user = null;
    }
@endphp
<x-default.layout :title="$page->metaTitle"
                  :description="$page->metaDescription"
                  :keywords="$page->keywords">
    <x-slot name="jumbotron">
        <x-ui.my-jumbotron>
            <x-default.partials.page-header :page="$page" />
        </x-ui.my-jumbotron>
    </x-slot>

    <div class="px-4 py-6">
        <div class="grid gap-2 sm:grid-cols-2 md:grid-cols-4 lg:inline-flex lg:flex-wrap">
            @foreach($tags as $tag)
                <a href="{{ route($routeName, ['filter[tag]' => $tag->name]) }}"
                   class="cursor-pointer group mb-2 sm:mb-0">
                    <span class="badge badge-soft badge-primary">{{ $tag->name }} {{-- ({{ $tag->contents_count }}) --}}</span>

                </a>
            @endforeach
        </div>
    </div>

</x-default.layout>
