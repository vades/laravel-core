<section {{$attributes->class(['flex gap-4 flex-col md:flex-row md:items-start mb-4'])}}>
    @if(isset($image))
        <figure {{$image->attributes->class([])}}>{{$image}}</figure>
    @endif
    <div>
        @if(!empty($title))
            <h1 {{$title->attributes->class(['text-3xl mb-2'])}}>
                {{ $title }}
            </h1>
        @endif
        @if(!empty($subtitle))
            <h2 {{$description->attributes->class(['text-xl mb-2'])}}>{{ $subtitle }}</h2>
        @endif
        @if(!empty($description))
            <div {{$description->attributes->class(['font-bold my-2'])}}>{{ $description }}</div>
        @endif
        @if(!empty($info))
            <div {{$info->attributes->class(['text-sm mb-3'])}}>{{ $info }}</div>
        @endif
    </div>

</section>