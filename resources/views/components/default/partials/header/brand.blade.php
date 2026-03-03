<div {{$attributes->class([])}}>
     <a class="header-logo" href="{{ route('home') }}"> <x-ui.my-img-svg img="laravel-core-logo" classList="[&>*]:w-12" /></a>
     <span class="header-slogan">{{ $globalNav['slogan'] }}</span>
</div>