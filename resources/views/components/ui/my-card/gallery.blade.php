
<div {{$attributes->class(['relative overflow-hidden rounded-sm'])}}>
                <figure class="relative overflow-hidden rounded-sm">
                        <img class="w-full aspect-square object-cover cursor-pointer
                                    transition-transform duration-300 ease-in-out hover:scale-110
                                    image-thumbnail rounded-sm"
                             src="{{$src}}"
                             alt="{{ $alt ?? 'image'}}"
                        >

                    @if(!empty($title))
                        <figcaption class="absolute bottom-0 left-0 right-0 p-2 bg-[rgba(255,255,255,0.6)] mt-2 text-center ">{{ $title}}</figcaption>
                    @endif
                </figure>
</div>