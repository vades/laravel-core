<section {{$attributes->class(['page-header'])}}>
    @if(isset($image))
        <figure {{$image->attributes->class([])}}>{{$image}}</figure>
    @endif
    <div>
        @if(!empty($title))
            <h1 {{$title->attributes->class(['page-header-title'])}}>
                {{ $title }}
            </h1>
        @endif
        @if(!empty($subtitle))
            <h2 {{$description->attributes->class(['pag-header-subtitle'])}}>{{ $subtitle }}</h2>
        @endif
        @if(!empty($description))
            <div {{$description->attributes->class(['page-header-description'])}}>{{ $description }}</div>
        @endif
        @if(!empty($info))
            <div {{$info->attributes->class(['page-header-info'])}}>{{ $info }}</div>
        @endif
    </div>

</section>