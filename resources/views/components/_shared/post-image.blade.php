@props(['postImage'])
<section {{$attributes->class([])}}>
    @if(!empty($postImage->title))
        <h3 class="pb-6 text-center !text-2xl font-bold">
            {{ $postImage->title }}
        </h3>
    @endif
    <img
            class="mx-auto h-auto rounded-lg object-cover max-h-[600px]"
            src="{{ $postImage->src }}"
            alt="{{ $postImage->title }}"
    >
    @if(!empty($postImage->description))
        <div class="mt-6 text-center">
            {{ $postImage->description }}
        </div>
    @endif
</section>