
<header class="bg-white dark:bg-neutral-900 shadow-md">
    <section class="container mx-auto flex justify-between items-center px-4 h-16">
        <x-default.partials.header.brand class="header-brand" />
        <div class="header-search">
            <livewire:widgets.search-suggestion :contentType="['article']" :placeholderText="__('app.search.blog')" />

        </div>
        <div>
            <livewire:widgets.categories-dropdown type="article"
                                                  route="articleIndex"
                                                  label="app.nav.categories" />
        </div>
        <div>
            <x-default.partials.header.nav class="header-nav" />
        </div>
    </section>
</header>