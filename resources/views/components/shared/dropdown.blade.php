<div x-data="{ open: false }" {{$attributes->class(['relative'])}}>
    @isset($header)
        <div {{$header->attributes->class([])}}
             @click="open = !open"
             @click.away="open = false"
             style="cursor:pointer;">
            {{$header}}
        </div>
    @endisset

    @isset($body)
        <!-- Dropdown menu -->
        <div {{$body->attributes->class(['absolute left-0 top-full mt-2 w-64 bg-white shadow-lg rounded z-50 max-h-128 overflow-auto divide-y divide-gray-100'])}}
             x-show="open"
             x-transition
             style="display: none;">

                {{$body}}

        </div>
    @endisset
</div>