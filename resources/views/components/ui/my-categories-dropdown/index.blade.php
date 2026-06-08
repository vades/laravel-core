


<div class="my-header-category">
    <!-- change popover-1 and --anchor-1 names. Use unique names for each dropdown -->
    <button class="btn my-btn-triangle-down" popovertarget="popoverHeaderCategories"
            style="anchor-name:--anchor-1">
        {{ $label }}
    </button>
    <ul class="dropdown menu"
        popover id="popoverHeaderCategories" style="position-anchor:--anchor-1">
        @foreach($composerCategories as $category)
            <li><a href="{{ route($route, ['filter[category]' => $category->slug]) }}">
                    {{ $category->title }}
                </a></li>
        @endforeach
    </ul>
</div>


