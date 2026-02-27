<x-ui.navbar {{$attributes->class(['hidden lg:flex lg:flex-1'])}}>
    @foreach($globalNav['header'] as $key => $val)
        <x-ui.navbar.item icon="{{$val['icon'] ?? ''}}"
                          label="{{ __($val['label'] ?? '') }}"
                          href="{{ route($val['name'], $val['params'] ?? []) }}" />
    @endforeach
</x-ui.navbar>