@php
$composerCategories = collect(data_get($composerCategory ?? [], $categoryType, []));
@endphp

@if($composerCategories->count() > 1)
<div class="my-header-category">
    <!-- change popover-1 and --anchor-1 names. Use unique names for each dropdown -->
    <button class="btn my-btn-triangle-down" popovertarget="{{$categoryType}}HeaderCategories"
            style="anchor-name:--anchor-{{$categoryType}}">
        {{ $label }}
    </button>
    <ul class="dropdown menu"
        popover id="{{$categoryType}}HeaderCategories" style="position-anchor:--anchor-{{$categoryType}}">
        @foreach($composerCategories as $category)
            <li><a href="{{ route($route, ['filter[category]' => $category->slug]) }}">
                    {{ $category->title }}
                </a></li>
        @endforeach
    </ul>
</div>
@endif
