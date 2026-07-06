<span {{$attributes->class(['badge'])}}>
    <span>
         {{ $slot }}
    </span>

     @isset($notify)
        <span {{$notify->attributes->class(['badge-notify'])}}>{{$notify}}</span>
    @endisset
</span>