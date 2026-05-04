<nav class="my-header-nav-lg">
        @foreach(config('myapp.headerNav') as $key => $val)
                <a class="my-nav-list-item {{$val['name'].'-'.$val['uri']}} item-{{$key}}" icon="{{$val['icon'] ?? ''}}"
                                  title="{{ __($val['label'] ?? '') }}"
                   href="{{ route($val['name'], $val['params'] ?? []) }}" >{{ __($val['label'] ?? '') }}</a>

    @endforeach
</nav>
