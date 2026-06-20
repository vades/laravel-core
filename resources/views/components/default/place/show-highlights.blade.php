@props(['highlights'])
<section class="list my-list lg:grid gap-4  lg:grid-cols-2">
    @foreach($highlights as $item)
        @php($item->created_at = null)
        @php($coverImage = !empty($item->cover_image_url) ? $item->cover_image_url : config('myapp.image.placeholder.place'))
        <x-ui.my-list class="my-list-row" :item="$item" :coverImage="$coverImage" />
    @endforeach
</section>
