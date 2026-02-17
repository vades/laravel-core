@inject('carbon', 'Carbon\Carbon')
<x-shared.page-header>
    @if(empty($page->featured_image_url) && !empty($page->cover_image_url))
        <x-slot name="image">
            <img src="{{asset($page->cover_image_url)}}"  alt="{{ $page->title }}">
        </x-slot>

    @endif

    <x-slot name="title">
        {{ $page->title }}
    </x-slot>
    <x-slot name="subtitle">
        {{ $page->subtitle ?? null }}
    </x-slot>
    <x-slot name="description">
        {{ $page->excerpt ?? null }}
    </x-slot>
        @if(isset($page->user->name))
            <x-slot name="info">
                <span class="mr-2">{{$page->user->name}}</span>
                <span class="posts-date">{{ $carbon::parse($page->createdAt)->format('Y-m-d') }}</span>
            </x-slot>
        @endif

</x-shared.page-header>