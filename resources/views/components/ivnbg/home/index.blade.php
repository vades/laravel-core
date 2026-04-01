<x-default.layout :title="$page->metaTitle ?? $page->title"
                  :description="$page->metaDescription ?? $page->excerpt"
                  :keywords="$page->keywords">
    @if(!empty($page))
        <x-ivnbg.home.hero :page="$page" />
    @endif
    @if($placesFeatured->isNotEmpty())
        <section class="mt-8">
            <x-ivnbg.home.places-featured :places="$placesFeatured" />
        </section>
    @endif

    @if($places->isNotEmpty())
        <section class="mt-8">
            <x-ivnbg.home.places :places="$places" />
        </section>
    @endif
    @if($articles->isNotEmpty())
        <section class="mt-8">
            <x-ivnbg.home.articles :articles="$articles" />
        </section>
    @endif

    @if(!empty($images))
        <section class="mt-8">
            <x-ivnbg.home.photo-gallery :images="$images" />
        </section>
    @endif

</x-default.layout>