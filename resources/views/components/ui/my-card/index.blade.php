<div {{$attributes->class(['flex flex-col justify-between h-full bg-white dark:bg-neutral-900 border border-black/10 dark:border-white/10 border-bor-base rounded-sm dark:hover:bg-neutral-800 my-card'])}}>
    @isset($header)
        <div {{$header->attributes->class([''])}}>{{$header}}</div>
    @endisset

    @isset($body)
        <div {{$body->attributes->class(['flex-grow px-6 py-4'])}}>{{$body}}</div>
    @endisset

    @isset($footer)
        <div {{$footer->attributes->class(['mt-auto text-center pb-4'])}}>{{$footer}}</div>
    @endisset
</div>