<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="{{ filled($description ?? null) ? $description : config('myapp.metaDescription') }}">
    <meta name="keywords"
          content="{{ filled($keywords ?? null) ? $keywords : config('myapp.metaKeywords') }}">
    <title>{{ filled($title ?? null) ? $title : config('myapp.metaTitle') }}</title>

    <!-- Canonical URL -->
    <link rel="canonical"
          href="{{ rtrim(config('app.url'), '/') . '/' . ltrim(request()->getPathInfo(), '/') . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}" />

    <!-- Styles / Scripts -->
    <x-ui.my-gtag />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite([$globalCssPath, 'resources/js/app.js'])
    @else
        @vite([$globalCssPath, 'resources/js/app.js'])
    @endif
    @livewireStyles
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>--}}
</head>
<body class="{{ request()->is('/') ? 'home' : str_replace('/', '-', request()->path()) }}">
<div id="root">
    {{-- #region Header --}}
    <x-default.partials.header />
    <div class="my-header-delimiter"></div>
    {{-- #endregion Header --}}
    @if(isset($jumbotron) && !empty($jumbotron))
        {{ $jumbotron }}
    @endif
    <main>
        {{ $slot }}
    </main>

   {{--  <x-default.partials.supplementary /> --}}

    <x-default.partials.footer />
</div>
@livewireScripts
</body>
</html>