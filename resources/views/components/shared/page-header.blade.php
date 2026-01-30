<header {{$attributes->class(['flex gap-4 flex-col md:flex-row md:items-start mb-4'])}}>
    @if(isset($image))
        <figure {{$image->attributes->class([])}}>{{$image}}</figure>
    @endif
    <div>
        @if(isset($title))
            <h1 {{$title->attributes->class(['text-3xl mb-2'])}}>
                {{ $title }}
            </h1>
        @endif
        @if(isset($subtitle))
            <h2 {{$description->attributes->class(['text-xl mb-2'])}}>{{ $subtitle }}</h2>
        @endif
        @if(isset($description))
            <div {{$description->attributes->class(['font-bold my-2'])}}>{{ $description }}</div>
        @endif
        @if(isset($info))
            <div {{$info->attributes->class(['text-sm mb-3'])}}>{{ $info }}</div>
        @endif
    </div>

</header>