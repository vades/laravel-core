@if (count($composerImages) > 1)
    @php
        $imagesCount = count($composerImages);
    @endphp

    <div class="carousel w-full">
        @foreach ($composerImages as $index => $image)
            @php
                $slideNumber = $index + 1;
                $previousSlideNumber = $slideNumber === 1 ? $imagesCount : $slideNumber - 1;
                $nextSlideNumber = $slideNumber === $imagesCount ? 1 : $slideNumber + 1;
            @endphp

            <div id="slide{{ $slideNumber }}" class="carousel-item relative w-full">
                <img
                    alt="Tailwind CSS slide example"
                    src="{{ $image }}"
                    class="w-full"
                />
                <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                    <a href="#slide{{ $previousSlideNumber }}" class="btn btn-circle">❮</a>
                    <a href="#slide{{ $nextSlideNumber }}" class="btn btn-circle">❯</a>
                </div>
            </div>
        @endforeach
    </div>
@endif
