
<nav {{$attributes->class([''])}}
     aria-label="Previous and next links">
    <!-- region previous  -->
    @if(isset($prevUrl))
            <x-ui.button href="{{$prevUrl}}" variant="solid"  icon="chevron-left" class="mr-4">{{__('app.nav.previous')}}</x-ui.button>
    @endif
    <!-- endregion -->
    <!-- region next  -->
    @if(isset($nextUrl))
        <x-ui.button href="{{$nextUrl}}" variant="solid"  iconAfter="chevron-right">{{__('app.nav.next')}}</x-ui.button>
    @endif
    <!-- endregion -->
</nav>