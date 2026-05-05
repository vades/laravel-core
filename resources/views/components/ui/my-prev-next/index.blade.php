
<nav {{$attributes->class(['my-prev-next'])}}
     aria-label="Previous and next links">
    <!-- region previous  -->
    @if(isset($prevUrl))
            <x-ui.button href="{{$prevUrl}}" variant="solid"  icon="chevron-left" class="my-prev-next-prev">{{__('app.nav.previous')}}</x-ui.button>
    @endif
    <!-- endregion -->
    <!-- region next  -->
    @if(isset($nextUrl))
        <x-ui.button href="{{$nextUrl}}" variant="solid"  iconAfter="chevron-right" class="my-prev-next-next">{{__('app.nav.next')}}</x-ui.button>
    @endif
    <!-- endregion -->
</nav>
