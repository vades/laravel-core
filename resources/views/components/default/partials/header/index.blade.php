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