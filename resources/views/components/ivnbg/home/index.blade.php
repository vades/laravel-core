<x-default.layout :title="$page->metaTitle ?? $page->title"
                  :description="$page->metaDescription ?? $page->excerpt"
                  :keywords="$page->keywords">
    @if(!empty($page))
        <x-ivnbg.home.hero :page="$page"/>
    @endif
    @if(count($placesFeatured) > 0)
        <section class="mt-8">
            <x-default.home.places-featured :placesFeatured="$placesFeatured"/>
        </section>
    @endif

    @if(count($places) > 0)
        <section class="mt-8">
            <x-default.home.places :places="$places"/>
        </section>
    @endif
        @if(count($articles) > 0)
            <section class="mt-8">
                <x-default.home.articles :articles="$articles"/>
            </section>
        @endif

        @if(count($images) > 0)
        <section class="mt-8">
            <x-default.home.photo-gallery :images="$images"/>
        </section>
    @endif

</x-default.layout>
