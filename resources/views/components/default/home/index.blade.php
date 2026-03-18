<x-default.layout>
    @if(!empty($page))
        <x-default.home.hero :page="$page"/>
    @endif

    <x-default.home.features />
        @if(!empty($placesFeatured))
            <section class="mt-8">
                <x-default.home.places-featured :places="$placesFeatured" />
            </section>
        @endif

        @if(!empty($places))
            <section class="mt-8">
                <x-default.home.places :places="$places" />
            </section>
        @endif
    @if(!empty($articles))
                    <section class="mt-8">
        <x-default.home.articles :articles="$articles"/>
                    </section>
    @endif

        @if(!empty($images))
                            <section class="mt-8">
            <x-default.home.photo-gallery :images="$images"/>
                            </section>
        @endif

</x-default.layout>