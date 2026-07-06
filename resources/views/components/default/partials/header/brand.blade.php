<div {{$attributes->class(['my-header-brand'])}}>
    <a class="my-header-logo"
       href="{{ route('home') }}">
        <x-ui.my-img-svg img="{{ config('myapp.logo')}}" classList="" />
    </a>
    <span class="my-header-slogan">{{ config('myapp.slogan') }}</span>
</div>