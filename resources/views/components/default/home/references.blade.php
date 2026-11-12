
<h2 class="text-center">{{__('app.nav.references')}}</h2>

    @php
        $imagesCount = count($references);
    @endphp

<section class="carousel w-full">
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

<div class="text-center">
    <a href="{{ route('referenceIndex') }}"
       class="btn btn-wide btn-ghost btn-primary my-btn-raquo">{{__('app.nav.allReferences')}}</a>
</div>