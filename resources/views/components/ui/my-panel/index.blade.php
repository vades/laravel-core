<div {{$attributes->class(['sm:flex sm:flex-row items-start gap-2 md:gap-4 bg-white dark:bg-neutral-900 border border-black/10 dark:border-white/10 border-bor-base rounded-sm dark:hover:bg-neutral-800'])}}>
    @isset($header)
        <div {{$header->attributes->class(['sm:w-1/3'])}}>{{$header}}</div>
    @endisset

    @isset($body)
        <div {{$body->attributes->class(['sm:w-2/3'])}}>{{$body}}</div>
    @endisset
</div>