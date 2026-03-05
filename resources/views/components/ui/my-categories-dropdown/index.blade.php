
@if(!empty($composerCategories) && $composerCategories->isNotEmpty())
    <x-ui.dropdown>
        <x-slot:button class="justify-center">
            <x-ui.navbar.item class="cursor-pointer" icon="chevron-down" label="{{ __('app.nav.categories') }}" />
        </x-slot:button>
        <x-slot:menu>
        @foreach($composerCategories as $category)
            @if($category->contents_count > 0)
                    <x-ui.dropdown.item href="{{ route($route, ['category' => $category->slug]) }}">
                        {{ $category->title }} ({{ $category->contents_count }})
                    </x-ui.dropdown.item>

            @endif
        @endforeach
        </x-slot:menu>
    </x-ui.dropdown>
@endif