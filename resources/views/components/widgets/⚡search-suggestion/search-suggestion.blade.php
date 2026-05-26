<div class="dropdown dropdown-open my-search-dropdown">
<label class="input w-full input-md input-primary">
    <x-ui.my-img-svg img="search" classList="my-icon"/>
    <input type="search" placeholder="{{$placeholderText}}"
           wire:model.live.debounce.300ms="query"
           wire:keydown.escape="reset"
           wire:keydown.tab="reset"
           wire:keydown.enter="selectResult"
           wire:keydown.arrow-down="moveSelectionDown"
           wire:keydown.arrow-up="moveSelectionUp"/>
</label>


{{-- The dropdown with the search results.
        It is only shown if the query is not empty and there are search results. --}}
@if(!empty($query) && !empty($results))

        <ul tabindex="-1" class="dropdown-content">
        @foreach($results as $key => $value)
            <li>
                <a
                    href="#"
                    wire:click.prevent="selectResult({{ $value->id }})"
                    @if($selectedResult === $key) style="font-weight:bold;" @endif
                >{{ $value->title }}</a>
            </li>
        @endforeach
    </ul>

    @endif


</div>
