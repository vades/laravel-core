<nav {{$attributes->class(['my-footer-nav'])}}>
    @foreach(config('myapp.footerNav') as $key => $val)
        <a class="{{$val['name'].'-'.$val['uri']}} item-{{$key}}" href="{{ route($val['name'], $val['params'] ?? []) }}">
            {{ __($val['label'] ?? '') }}
        </a>
    @endforeach
</nav>