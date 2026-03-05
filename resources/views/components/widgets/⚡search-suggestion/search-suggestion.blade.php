<x-ui.my-dropdown>
    <x-slot name="header">

        <div class="relative">
            <x-ui.input
                    type="text"
                    class="form-input has-icon-end"
                    placeholder="{{$placeholderText}}."
                    wire:model.live.debounce.300ms="query"
                    wire:keydown.escape="reset"
                    wire:keydown.tab="reset"
                    wire:keydown.enter="selectResult"
                    wire:keydown.arrow-down="moveSelectionDown"
                    wire:keydown.arrow-up="moveSelectionUp"
                    suffixIcon="magnifying-glass"
            />
        </div>
    </x-slot>
    {{-- The dropdown with the search results.
            It is only shown if the query is not empty and there are search results. --}}
    @if(!empty($query) && !empty($results))
        <x-slot name="body" class="w-full">
            <ul>
                @foreach($results as $key => $value)
                    <li class="block px-4 py-2 hover:dark:text-neutral-100 hover:bg-neutral-100 hover:dark:bg-neutral-700 cursor-pointer text-lg {{ $selectedResult === $key ? 'is-selected' : '' }}">
                        <a
                                href="#"
                                wire:click.prevent="selectResult({{ $value->id }})"
                                @if($selectedResult === $key) style="font-weight:bold;" @endif
                        >{{ $value->title }}</a>
                    </li>
                @endforeach
            </ul>
        </x-slot>
    @endif
</x-ui.my-dropdown>