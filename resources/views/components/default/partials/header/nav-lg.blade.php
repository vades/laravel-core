<x-ui.navbar {{$attributes->class(['hidden lg:flex lg:flex-1 my-header-navbar'])}}>
        @foreach(config('myapp.headerNav') as $key => $val)
        <x-ui.navbar.item class="my-nav-list-item {{$val['name'].'-'.$val['uri']}} item-{{$key}}" icon="{{$val['icon'] ?? ''}}"
                          label="{{ __($val['label'] ?? '') }}"
                          href="{{ route($val['name'], $val['params'] ?? []) }}" />
    @endforeach
</x-ui.navbar>