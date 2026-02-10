<header id="header"
        class="text-header bg-bcg-header shadow-md">
    <section class="container mx-auto flex justify-between items-center px-4 h-16">
        <div>
            <x-default.partials.header.brand class="flex items-center gap-8" />
        </div>
        <div class="flex-1 mx-4">
            <livewire:widgets.search-suggestion :contentType="['article']"
                                                :placeholderText="'Search in blog'" />

        </div>
        <div>
            <livewire:widgets.categories-dropdown type="article"
                                                  route="articleIndex"
                                                  label="articleCategories" />
        </div>
        <div>
            <x-default.partials.header.nav />
        </div>
    </section>
</header>