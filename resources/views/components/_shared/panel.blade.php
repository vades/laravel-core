<div {{$attributes->class(['panel'])}}>
    @isset($header)
        <div {{$header->attributes->class(['panel-heade'])}}>{{$header}}</div>
    @endisset

    @isset($body)
        <div {{$body->attributes->class(['panel-body'])}}>{{$body}}</div>
    @endisset
</div>