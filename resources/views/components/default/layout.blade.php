<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="{{ $description ?? config('myapp.metaDescription') }}">
    <meta name="keywords"
          content="{{ $keywords ?? config('myapp.metaKeywords') }}">
    <title>{{ $title ??  config('myapp.metaTitle') }}</title>

    <!-- Canonical URL -->
    <link rel="canonical"
          href="{{ rtrim(config('app.url'), '/') . '/' . ltrim(request()->getPathInfo(), '/') . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}" />

    <!-- Styles / Scripts -->
    <x-shared.gtag />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite([$globalCssPath, 'resources/js/app.js'])
    @else
        @vite([$globalCssPath, 'resources/js/app.js'])
    @endif
    @livewireStyles
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>--}}
</head>
<body class="{{ str_replace('/', '-', request()->path()) }}">
<div id="root">
    {{-- #region Header --}}
    <header id="header">
        <section class="header-container">
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
    {{-- #endregion Header --}}
    @if(isset($jumbotron) && !empty($jumbotron))
        <section>{{ $jumbotron }}</section>
    @endif
    <main>
        {{ $slot }}
    </main>
    <section id="supplementary">
        <div class="supplementary-container">
            suplementary
            {{--   <x-web.ivnbg.partials.supplementary.blog />
              <x-web.ivnbg.partials.supplementary.place />
              <x-web.ivnbg.partials.supplementary.album /> --}}
        </div>

    </section>

    <footer id="footer">
        <section class="footer-container">
            <x-default.partials.footer.brand class="footer-brand" />
            <x-default.partials.footer.nav class="footer-nav" />
        </section>
    </footer>

</div>
@livewireScripts
</body>
</html>