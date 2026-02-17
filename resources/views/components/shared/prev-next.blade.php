
    <nav  {{$attributes->class(['flex'])}}
         aria-label="Previous and next links">
        <!-- region previous  -->
        @if(isset($prevUrl))
            <a href="{{$prevUrl}}"
               class="button before:content-['\2039'] before::ml-2 rtl:after:rotate-180">
                Previous
            </a>
        @endif
        <!-- endregion -->
        <!-- region next  -->
        @if(isset($nextUrl))
            <a href="{{$nextUrl}}"
               class="button after:content-['\203A'] after:ml-2 rtl:after:rotate-180">
                Next
            </a>
        @endif
        <!-- endregion -->
    </nav>