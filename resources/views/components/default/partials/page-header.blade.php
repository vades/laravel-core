<section class="flex flex-col md:flex-row md:items-start">
    @if(isset($page->imageUrl) && !empty($page->imageUrl))
        <figure class="mb-3 md:mr-3">
            <img class="md:max-w-xs border-4 border-skin-muted drop-shadow-lg"
                 src="{{$page->imageUrl}}"
                 alt="{{ $page->title }}">
        </figure>
    @endif
    <div>
        <h1 class="text-3xl mb-2">{{ $page->title }}</h1>
        @if(isset($page->subtitle) && !empty($page->subtitle))
            <h2 class="text-xl mb-2">{{ $page->subtitle }}</h2>
        @endif
        @if(isset($page->description) && !empty($page->description))
            <div class="font-bold my-2">{{ $page->description }}</div>
        @endif
    </div>
</section>