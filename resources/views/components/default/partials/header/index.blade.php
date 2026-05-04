<header class="my-header">
    <div class="my-header-stripe"></div>
    <section class="my-header-container">
        <x-default.partials.header.brand  />
        @if(!empty(config('myapp.headerWidgets.searchInContentType')))
            <div class="my-header-search">
                <livewire:widgets.search-suggestion :contentType="config('myapp.headerWidgets.searchInContentType')" :placeholderText="__('app.search.all')" />

            </div>

        @endif

        @if(!empty(config('myapp.headerWidgets.articleCategories')))
            <div class="my-header-category">
                <x-ui.my-categories-dropdown categoryType="article"
                                             route="articleIndex"
                                             label="{{ __('app.nav.articleIndex') }}" />
            </div>

        @endif

        @if(!empty(config('myapp.headerWidgets.placeCategories')))
            <div class="my-header-category">
                <x-ui.my-categories-dropdown categoryType="place"
                                             route="placeIndex"
                                             label="{{ __('app.nav.placeIndex') }}" />
            </div>

        @endif
        <div>
            <x-default.partials.header.nav-lg tagType="article"/>
            <x-default.partials.header.nav-sm categoryType="article"/>
        </div>
    </section>
</header>
