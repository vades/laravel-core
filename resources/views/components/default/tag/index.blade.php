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
                    <x-ui.badge
                            variant="outline"
                            size="lg"
                            class="w-full justify-center lg:w-auto transition-all duration-200 group-hover:scale-105 whitespace-normal break-words text-center"
                    >
                        {{ $tag->name }} ({{ $tag->contents_count }})
                    </x-ui.badge>
                </a>
            @endforeach
        </div>
    </div>

</x-default.layout>