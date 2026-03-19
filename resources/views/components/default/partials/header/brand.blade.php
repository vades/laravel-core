<div {{$attributes->class([])}}>
     <a class="header-logo" href="{{ route('home') }}">
         @if(!empty($globalNav['logo']))

             <x-ui.my-img-svg img="{{ $globalNav['logo'] }}" classList="" />
         @endif

     </a>
     <span class="hidden lg:inline">{{ $globalNav['slogan'] }}</span>
</div>