<article {{$attributes->class(['sm:flex sm:flex-row items-start gap-2 md:gap-4'])}}>
    @isset($header)
        <header {{$header->attributes->class(['sm:w-1/3'])}}>{{$header}}</header>
    @endisset

    @isset($body)
        <div {{$body->attributes->class(['sm:w-2/3'])}}>{{$body}}</div>
    @endisset
</article>