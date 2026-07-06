@inject('carbon', 'Carbon\Carbon')

<h2>{{__('app.nav.recentPosts')}}</h2>

<section class="list my-list lg:grid gap-4  lg:grid-cols-2">
    @foreach($articles as $item)
        @php($coverImage = !empty($item->cover_image_url) ? $item->cover_image_url : config('myapp.image.placeholder.article'))

        <x-ui.my-list class="my-list-row" :item="$item" :coverImage="$coverImage" routeName="articleShow" />

    @endforeach
</section>
<div class="text-center">
    <a href="{{ route('articleIndex') }}"
       class="btn btn-wide btn-ghost btn-primary my-btn-raquo">{{__('app.nav.allArticles')}}</a>
</div>
