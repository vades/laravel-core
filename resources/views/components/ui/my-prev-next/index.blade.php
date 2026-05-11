
<nav {{$attributes->class(['my-prev-next'])}}
     aria-label="Previous and next links">
    <!-- region previous  -->
    @if(isset($prevUrl))
            <a href="{{$prevUrl}}" class="btn btn-outline btn-primary my-btn-laquo">{{__('app.nav.previous')}}</a>
    @endif
    <!-- endregion -->
    <!-- region next  -->
    @if(isset($nextUrl))
        <a href="{{$nextUrl}}" class="btn btn-outline btn-primary my-btn-raquo">{{__('app.nav.next')}}</a>
    @endif
    <!-- endregion -->
</nav>
