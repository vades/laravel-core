@props(['related'])

<section class="grid gap-2 sm:grid-cols-2 lg:grid-cols-5 lg:gap-3 2xl:grid-cols-7 xl:gap-4 content-wrapper my-grid-place my-grid-place-related">
    @foreach($related as $item)
        @php($item->excerpt = null)
        @php($coverImage = !empty($item->cover_image_url) ? $item->cover_image_url : config('myapp.image.placeholder.place'))

        <x-ui.my-card.place :item="$item" :coverImage="$coverImage" />

    @endforeach
</section>
