
@props(['type' => 'place','route' => 'placeList','label' => 'placeCategoryList'])
@if(isset($categories) && count($categories) > 0)
    <x-utils.dropdown>
        <x-slot name="header">
        <span class="flex items-center gap-2">
            {{ __($label) }}
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-4 h-4"
                 fill="none"
                 viewBox="0 0 24 24">
                <path stroke="currentColor"
                      stroke-width="2"
                      d="M6 9l6 6 6-6" />
            </svg>
        </span>
        </x-slot>

        <x-slot name="body"
                class="dropdown">
            <ul class="dropdown-container">
                @foreach($categories as $category)
                    @if($category->posts_count > 0)
                        <li class="dropdown-list-item">
                            <a
                                    href="{{ route($route, ['category' => $category->slug]) }}">
                                @if(isset($currentCategory)  && $currentCategory === $category->slug)
                                    <strong>{{ $category->title }} ({{ $category->posts_count }})</strong>
                                @else
                                    {{ $category->title }} ({{ $category->posts_count }})
                                @endif
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </x-slot>
    </x-utils.dropdown>
@endif