@if($categories->isNotEmpty())
    <x-ui.dropdown>
        <x-slot:button class="justify-center">
            <x-ui.button variant="outline">
              Categories
            </x-ui.button>
        </x-slot:button>
        <x-slot:menu>
        @foreach($categories as $category)
            @if($category->contents_count > 0)
                    <x-ui.dropdown.item href="{{ route($route, ['category' => $category->slug]) }}" icon="home">
                        {{ $category->title }} ({{ $category->contents_count }})
                    </x-ui.dropdown.item>

            @endif
        @endforeach
        </x-slot:menu>
    </x-ui.dropdown>
@endif