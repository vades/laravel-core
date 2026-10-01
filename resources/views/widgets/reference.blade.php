
<h2 class="text-center">
    @if($widget->has_icon)  <x-ui.my-img-svg img="{{ $widget->has_icon}}" classList="my-widget-icon" /> @endif
   {{$widget->title}}
</h2>
<section class="carousel w-full my-widget-reference">
    @php
        $imagesCount = count($references);
    @endphp
    @foreach ($references as $index => $item)
     
        @php
        $featuredImage = !empty($item->featured_image_url) ? $item->featured_image_url : config('myapp.image.placeholder.reference');
            $slideNumber = $index + 1;
            $previousSlideNumber = $slideNumber === 1 ? $imagesCount : $slideNumber - 1;
            $nextSlideNumber = $slideNumber === $imagesCount ? 1 : $slideNumber + 1;
        @endphp

        <div id="slide{{ $slideNumber }}" class="carousel-item relative w-full">
            {{-- <a href="{{ route('referenceShow',  ['slug'=>$item->slug]) }}"> --}}
            <img
                alt="{{ $item->title }}"
                src="{{ $featuredImage }}"
                class="w-full"
            />
            {{-- </a> --}}
            <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                <a href="#slide{{ $previousSlideNumber }}" class="btn btn-circle">❮</a>
                <a href="#slide{{ $nextSlideNumber }}" class="btn btn-circle">❯</a>
            </div>
        </div>
    @endforeach
    </section>

    <div class="my-widget-body text-center"> {!! $widget->rendered_content !!}</div>