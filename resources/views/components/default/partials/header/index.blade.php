<header id="header" class="text-header bg-bcg-header shadow-md">
    <section class="container mx-auto flex justify-between items-center px-4 h-16">
        <div>
            <x-web.ivnbg.partials.header.brand class="flex items-center gap-8"/>
        </div>
        <div class="flex-1 mx-4">
            @livewire('search-autocomplete')
        </div>
        <div>
            <x-web.ivnbg.partials.header.nav />
        </div>
    </section>
</header>