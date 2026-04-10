<nav {{$attributes->class(['text-center'])}}>
    @foreach(config('myapp.footerNav') as $key => $val)
        <x-ui.link class="!block !text-center !pb-4 md:!inline md:!pb-0 md:pl-4 {{$val['name'].'-'.$val['uri']}} item-{{$key}}" href="{{ route($val['name'], $val['params'] ?? []) }}">
            {{ __($val['label'] ?? '') }}
        </x-ui.link>
    @endforeach
</nav>