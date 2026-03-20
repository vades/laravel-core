<div {{$attributes->class([])}}>
    <a class="header-logo"
       href="{{ route('home') }}">
        <x-ui.my-img-svg img="{{ config('myapp.logo')}}" classList="" />
    </a>
    <span class="hidden lg:inline">{{ config('myapp.slogan') }}</span>
</div>