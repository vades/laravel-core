<div {{$attributes->class([])}}>
     <a class="header-logo" href="{{ route('home') }}">
         <x-ui.my-img-svg img="laravel-core-logo" classList="[&>*]:w-6 lg:[&>*]:w-12" />
     </a>
     <span class="hidden lg:inline">{{ $globalNav['slogan'] }}</span>
</div>