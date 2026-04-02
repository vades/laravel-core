@inject('carbon', 'Carbon\Carbon')
<x-ui.my-card class="my-card-article">
    <x-slot name="header">
        <img class="w-full h-64 object-cover mb-4 rounded-t-sm"
             src="{{asset($coverImage)}}"
             alt="{{ $item->title}}">
    </x-slot>
    <x-slot name="body">

        <h2 class="text-2xl font-bold mb-2">
            <a href="{{ route('articleShow',  ['slug'=>$item->slug]) }}">{{ $item->title }} </a></h2>
        <p class="text-sm mb-3">{{ $carbon::parse($item->created_at)->format('Y-m-d') }}</p>

        <div class="card-excerpt">
            {{ $item->excerpt }}
        </div>
    </x-slot>
    <x-slot name="footer">
        <x-ui.button href="{{ route('articleShow',  ['slug'=>$item->slug]) }}"
                     variant="solid" size="lg"  iconAfter="chevron-right">{{__('app.nav.readMore')}}</x-ui.button>
    </x-slot>
</x-ui.my-card>