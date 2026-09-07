@inject('carbon', 'Carbon\Carbon')
<x-ui.my-card class="my-card my-card-article">
    <x-slot name="header">
        <img class="my-card-img"
             src="{{asset($featuredImage)}}"
             alt="{{ $item->title}}">
    </x-slot>
    <x-slot name="body">
        <div class="my-card-title">
            <a href="{{ route('referenceShow',  ['slug'=>$item->slug]) }}">{{ $item->title }} </a></div>

        <div class="my-card-excerpt">
            {{ $item->excerpt }}
        </div>
    </x-slot>
    <x-slot name="footer">
        <a href="{{ route('referenceShow',  ['slug'=>$item->slug]) }}" class="btn btn-ghost my-btn-raquo">{{__('app.nav.readMore')}}</a>
    </x-slot>
</x-ui.my-card>
