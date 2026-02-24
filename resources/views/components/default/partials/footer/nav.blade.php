<nav {{$attributes->class([])}}>
    @foreach($globalNav['footer'] as $key => $val)
                <x-ui.link class="pl-4" href="{{ route($val['name'], $val['params'] ?? []) }}">
                        {{ __($val['label'] ?? '') }}
                </x-ui.link>
    @endforeach
</nav>