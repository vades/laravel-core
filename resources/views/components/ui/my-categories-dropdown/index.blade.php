

    <x-ui.dropdown>
        <x-slot:button class="justify-center">
            <x-ui.navbar.item class="cursor-pointer" icon="chevron-down" label="{{ __('app.nav.categories') }}" />
        </x-slot:button>
        <x-slot:menu>
        @foreach($composerCategories as $category)
                    <x-ui.dropdown.item href="{{ route($route, ['filter[category]' => $category->slug]) }}">
                        {{ $category->title }} ({{ $category->contents_count }})
                    </x-ui.dropdown.item>
        @endforeach
        </x-slot:menu>
    </x-ui.dropdown>