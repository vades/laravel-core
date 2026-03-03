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
        <div {{$body->attributes->class([''])}}
             x-show="open"
             x-transition
             style="display: none;">

                {{$body}}

        </div>
    @endisset
</div>