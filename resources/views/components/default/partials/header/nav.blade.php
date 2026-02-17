<nav {{$attributes->class([])}}>
     @foreach($globalNav['header'] as $key => $val)
        <a href="{{ route($val['name'], $val['params'] ?? []) }}">{{ __($val['label'] ?? '') }}</a>
    @endforeach
</nav>