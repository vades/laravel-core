<x-default.layout :title="$page->metaTitle ?? $page->title"
                  :description="$page->metaDescription ?? $page->excerpt"
                  :keywords="$page->keywords">
    @if(!empty($page))
        <x-slot name="jumbotron">
            <x-ui.my-jumbotron class="my-home-jumbotron">
                <x-ivnbg.home.hero :page="$page" />
                @if($placesFeatured->isNotEmpty())
                    <section class="my-homepage-section pb-4">
                        <x-ivnbg.home.places-featured :places="$placesFeatured" />
                    </section>
                @endif
            </x-ui.my-jumbotron>
        </x-slot>

    @endif


    @if($places->isNotEmpty())
        <section class="my-homepage-section">
            <x-ivnbg.home.places :places="$places" />
        </section>
    @endif
    @if($articles->isNotEmpty())
        <section class="my-homepage-section border border-gray-200">
            <x-ivnbg.home.articles :articles="$articles" />
        </section>
    @endif

    @if(!empty($images))
        <section class="my-homepage-section border border-black/10 dark:border-white/10 bg-bcg-base/80 p-4 rounded">
            <x-ivnbg.home.photo-gallery :images="$images" />
        </section>
    @endif

</x-default.layout>