<section {{$attributes->class(['my-page-header'])}}>
    @if(isset($image))
        <figure {{$image->attributes->class([])}}>{{$image}}</figure>
    @endif
    <div>
        @if(!empty($title))
            <h1 {{$title->attributes->class(['my-page-header-title'])}}>  {{ $title }}</h1>

        @endif
        @if(!empty($subtitle))
                <h2 {{$description->attributes->class(['my-page-header-subtitle'])}}>{{ $subtitle }}</h2>
        @endif
        @if(!empty($description))
            <div {{$description->attributes->class(['my-page-header-description'])}}>{{ $description }}</div>
        @endif
        @if(!empty($info))
            <div {{$info->attributes->class(['my-page-header-info'])}}>{{ $info }}</div>
        @endif
    </div>

</section>
