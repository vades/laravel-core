@inject('carbon', 'Carbon\Carbon')

<div {{$attributes->class(['list-row'])}}>
    <div>
        <img class="my-list-img"  src="{{asset($coverImage)}}" alt="{{ $item->title}}"/>
    </div>
    <div>
        <div class="my-list-title" ><a href="{{ route($routeName,  ['slug'=>$item->slug]) }}">{{ $item->title }} </a></div>
        @if (filled($item->subtitle))
            <div class="my-list-subtitle">{{ $item->subtitle }}</div>
        @endif
        @if (filled($item->created_at))
            <div class="my-list-date">{{ $carbon::parse($item->created_at)->format('Y-m-d') }}</div>
        @endif
        @if (filled($item->excerpt ))
            <div class="my-excerpt">{{ $item->excerpt }}</div>
        @endif
    </div>
    <a class="btn btn-square btn-ghost" href="{{ route($routeName,  ['slug'=>$item->slug]) }}">
        <x-ui.my-img-svg img="circle-chevron-right" classList="my-icon"/>
    </a>
</div>
