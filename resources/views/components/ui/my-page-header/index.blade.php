<section {{$attributes->class(['flex gap-4 flex-col md:flex-row md:items-start mb-4 page-header '])}}>
    @if(isset($image))
        <figure {{$image->attributes->class([])}}>{{$image}}</figure>
    @endif
    <div>
        @if(!empty($title))
            <x-ui.heading class="{{$title->attributes->class([])}}" level="h1" size="xl">  {{ $title }}</x-ui.heading>

        @endif
        @if(!empty($subtitle))
                <x-ui.heading class="{{$description->attributes->class([])}}" level="h2" size="lg">{{ $subtitle }}</x-ui.heading>
        @endif
        @if(!empty($description))
            <div {{$description->attributes->class(['font-bold my-2'])}}>{{ $description }}</div>
        @endif
        @if(!empty($info))
            <div {{$info->attributes->class(['text-sm mb-3'])}}>{{ $info }}</div>
        @endif
    </div>

</section>