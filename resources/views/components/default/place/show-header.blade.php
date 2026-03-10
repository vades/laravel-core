
<section {{$attributes->class(['sm:flex justify-between gap-8 flex-wrap'])}}>
    @if(!empty($page->cover_image_url))
        <div class="max-sm:w-full">
            <figure class="w-64 h-64 p-2 max-sm:mx-auto">
                <img class="h-full w-full object-cover max-w-[300px] rounded-full border-8 border-white"
                     src="{{ asset($page->cover_image_url)}}"
                     alt="{{  $page->title }}">
            </figure>
        </div>

    @endif

        <div class="flex-1">
            @if(isset($page->title) && !empty($page->title))
                <x-ui.heading level="h1" size="xl">  {{ $page->title }}</x-ui.heading>

            @endif

            @if(isset($page->subtitle) && !empty($page->subtitle))
                    <x-ui.heading  level="h2" size="lg">{{ $page->subtitle }}</x-ui.heading>
            @endif

            @if(isset($page->excerpt) && !empty($page->excerpt))
                <div class="perex">{{ $page->excerpt }}</div>
            @endif

            @if(isset($page->address) && !empty($page->address))
                <div class="mb-4"><span class="font-bold">{{__('address')}}:</span> {{ $page->address }}</div>
            @endif
        </div>
        @if(isset($page->googleMapEmbedUrl))
            <div class="w-full basis-full lg:basis-1/3 border-8 border-white shadow-sm">
                <x-ui.my-iframe :src="$page->googleMapEmbedUrl" />
            </div>
        @endif

</section>