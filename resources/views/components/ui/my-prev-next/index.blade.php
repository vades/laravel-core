
<nav {{$attributes->class([''])}}
     aria-label="Previous and next links">
    <!-- region previous  -->
    @if(isset($prevUrl))
            <x-ui.button href="{{$prevUrl}}" variant="outline" class="before:content-['\2039'] before::ml-2 rtl:after:rotate-180 mr-4">{{__('app.nav.previous')}}</x-ui.button>
    @endif
    <!-- endregion -->
    <!-- region next  -->
    @if(isset($nextUrl))
        <x-ui.button href="{{$nextUrl}}" variant="outline" class="after:content-['\203A'] after:ml-2 rtl:after:rotate-180">{{__('app.nav.next')}}</x-ui.button>
    @endif
    <!-- endregion -->
</nav>