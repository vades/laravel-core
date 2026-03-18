@inject('carbon', 'Carbon\Carbon')

    <x-ui.heading level="h2"
                  size="lg"
                  class="!text-center">{{__('app.nav.recentPosts')}}</x-ui.heading>
    <div class="md:grid  gap-2 md:grid-cols-2 lg:grid-cols-3  my-8">
        @foreach($articles as $item)
            @php($coverImage = !empty($item->cover_image_url) ? $item->cover_image_url : config('myapp.image.placeholder.article'))

        <x-ui.my-card.article :item="$item" :coverImage="$coverImage" />

        @endforeach
    </div>
    <div class="text-center">
        <x-ui.button href="{{ route('articleIndex') }}"
                     variant="outline"
                     class="after:content-['\203A'] after:ml-2 rtl:after:rotate-180">{{__('app.nav.allArticles')}}</x-ui.button>
    </div>