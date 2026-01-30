<nav {{$attributes->class([])}}>
    @foreach(config('myapp.footerNav') as $key => $val)
        <a href="{{ route($val['name'], $val['params'] ?? []) }}">{{ __($val['label'] ?? '') }}</a>
    @endforeach
</nav>