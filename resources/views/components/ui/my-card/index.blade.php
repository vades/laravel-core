<div {{$attributes->class(['my-card'])}}>
    @isset($header)
        <div {{$header->attributes->class(['my-card-header'])}}>{{$header}}</div>
    @endisset

    @isset($body)
        <div {{$body->attributes->class(['my-card-body'])}}>{{$body}}</div>
    @endisset

    @isset($footer)
        <div {{$footer->attributes->class(['my-card-footer'])}}>{{$footer}}</div>
    @endisset
</div>
