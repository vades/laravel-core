@inject('carbon', 'Carbon\Carbon')

    <x-ui.heading level="h2"
                  size="lg"
                  class="!text-center">{{__('app.nav.recentPosts')}}</x-ui.heading>
    <div class="md:grid  gap-2 md:grid-cols-2 lg:grid-cols-3 mb-4">
        @foreach($articles as $item)
            @php($coverImage = !empty($item->cover_image_url) ? $item->cover_image_url : config('myapp.image.placeholder.article'))

        <x-ui.my-card.article :item="$item" :coverImage="$coverImage" />

        @endforeach
    </div>
    <div class="text-center">
        <a href="{{ route('articleIndex') }}"
                     class="btn btn-wide btn-outline btn-primary my-btn-raquo">{{__('app.nav.allArticles')}}</a>
    </div>
