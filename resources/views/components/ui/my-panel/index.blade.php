<div {{$attributes->class(['my-panel'])}}>
    @isset($header)
        <div {{$header->attributes->class(['my-panel-header'])}}>{{$header}}</div>
    @endisset

    @isset($body)
        <div {{$body->attributes->class(['my-panel-body'])}}>{{$body}}</div>
    @endisset
</div>
