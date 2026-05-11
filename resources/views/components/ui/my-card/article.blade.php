@inject('carbon', 'Carbon\Carbon')
<x-ui.my-card class="my-card-article">
    <x-slot name="header">
        <img class="my-card-article-img"
             src="{{asset($coverImage)}}"
             alt="{{ $item->title}}">
    </x-slot>
    <x-slot name="body">
        <h2 class="my-card-article-heading ">
            <a href="{{ route('articleShow',  ['slug'=>$item->slug]) }}">{{ $item->title }} </a></h2>
        <p class="text-sm mb-3">{{ $carbon::parse($item->created_at)->format('Y-m-d') }}</p>

        <div class="my-card-excerpt">
            {{ $item->excerpt }}
        </div>
    </x-slot>
    <x-slot name="footer">
        <a href="{{ route('articleShow',  ['slug'=>$item->slug]) }}" class="btn btn-outline btn-primary my-btn-raquo">{{__('app.nav.readMore')}}</a>
    </x-slot>
</x-ui.my-card>
