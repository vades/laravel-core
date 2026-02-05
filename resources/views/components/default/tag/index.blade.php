<x-default.layout :title="$page->metaTitle"
                    :description="$page->metaDescription"
                    :keywords="$page->keywords">
    <x-slot name="jumbotron">
        <x-shared.jumbotron>
            <x-default.partials.page-header :page="$page" />
        </x-shared.jumbotron>
    </x-slot>
    @foreach($page->tags as $tag)
        <a href="{{ route('articleIndex', ['tag' => $tag->name]) }}">
            <x-shared.badge class="block w-full sm:inline-block sm:w-1/5 mb-2 sm:mr-2" > {{ $tag->name }}
                <x-slot name="notify">{{ $tag->contents_count }}</x-slot>
            </x-shared.badge>

        </a>

    @endforeach

</x-default.layout>