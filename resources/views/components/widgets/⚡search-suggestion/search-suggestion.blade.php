<x-shared.dropdown>
    <x-slot name="header">

        <div class="relative">
            <div class="absolute inset-y-0 end-2.5 flex items-center ps-3.5 pointer-events-none">
                <x-shared.img-svg img="search"
                                 classList="[&>svg]:text-gray-500" />
            </div>
            <input
                    type="text"
                    class="form-input has-icon-end"
                    placeholder="{{$placeholderText}}."
                    wire:model.live.debounce.300ms="query"
                    wire:keydown.escape="reset"
                    wire:keydown.tab="reset"
                    wire:keydown.enter="selectResult"
                    wire:keydown.arrow-down="moveSelectionDown"
                    wire:keydown.arrow-up="moveSelectionUp"
            />
        </div>
    </x-slot>
    {{-- The dropdown with the search results.
            It is only shown if the query is not empty and there are search results. --}}
    @if(!empty($query) && !empty($results))
        <x-slot name="body"
                class="dropdown">
            <ul class="dropdown-container">
                @foreach($results as $key => $value)
                    <li class="dropdown-list-item {{ $selectedResult === $key ? 'bg-blue-100' : '' }}">
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
</x-shared.dropdown>