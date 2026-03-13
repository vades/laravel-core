@inject('carbon', 'Carbon\Carbon')
<x-ui.my-card>
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
                     variant="outline"
                     class="after:content-['\203A'] after:ml-2 rtl:after:rotate-180">{{__('app.nav.readMore')}}</x-ui.button>
    </x-slot>
</x-ui.my-card>