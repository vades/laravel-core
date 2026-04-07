

<header class="bg-white dark:bg-neutral-900 border-b border-black/10 dark:border-white/10 my-header">
    <section class="container mx-auto flex justify-between items-center px-4 lg:px-0 h-16">
        <x-default.partials.header.brand class="flex  justify-between items-center gap-6" />
        @if(!empty(config('myapp.headerWidgets.searchInContentType')))
            <div class="flex-1 mx-4">
                <livewire:widgets.search-suggestion :contentType="config('myapp.headerWidgets.searchInContentType')" :placeholderText="__('app.search.all')" />

            </div>

        @endif

        @if(!empty(config('myapp.headerWidgets.articleCategories')))
            <div class="hidden lg:inline">
                <x-ui.my-categories-dropdown categoryType="article"
                                             route="articleIndex"
                                             label="{{ __('app.nav.articleIndex') }}" />
            </div>

        @endif

        @if(!empty(config('myapp.headerWidgets.articleCategories')))
            <div class="hidden lg:inline">
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