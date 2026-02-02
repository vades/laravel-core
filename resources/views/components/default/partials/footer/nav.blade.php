<nav {{$attributes->class([])}}>
    @foreach($globalNav['footer'] as $key => $val)
        <a href="{{ route($val['name'], $val['params'] ?? []) }}">{{ __($val['label'] ?? '') }}</a>
    @endforeach
</nav>