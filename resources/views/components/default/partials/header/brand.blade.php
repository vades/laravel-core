<div {{$attributes->class([])}}>
    <a class="flex items-center gap-8" href="{{ route('home') }}"> <x-utils.img-svg img="ivnbg" classList="[&>*]:w-28" /> <span class="slogan">{{ config('myapp.slogan') }}</span></a>
</div>