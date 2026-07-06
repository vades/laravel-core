<x-default.layout :title="$page->metaTitle ?? $page->title"
                  :description="$page->metaDescription ?? $page->excerpt"
                  :keywords="$page->keywords">
    @if(!empty($page))
        <x-slot name="jumbotron">
            <x-ui.my-jumbotron class="">
                <x-vades.home.hero :page="$page" />
            </x-ui.my-jumbotron>
        </x-slot>

    @endif

        <section class="my-homepage-section">
            <x-vades.home.features />
        </section>

        <section class="my-homepage-section">
            <x-vades.home.contact />
        </section>

    @if($articles->isNotEmpty())
        <section class="my-homepage-section">
            <x-vades.home.articles :articles="$articles" />
        </section>
    @endif


</x-default.layout>
