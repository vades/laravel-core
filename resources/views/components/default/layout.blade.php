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
    <link rel="canonical" href="{{ rtrim(config('app.url'), '/') . '/' . ltrim(request()->getPathInfo(), '/') . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}" />

    <!-- Styles / Scripts -->
    <x-utils.gtag />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/' . config('myapp.project') . '/app.css', 'resources/js/app.js'])
    @else
        @vite(['resources/css/' . config('myapp.project') . '/app.css', 'resources/js/app.js'])
    @endif
    @livewireStyles
   {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>--}}
</head>
<body class="{{ str_replace('/', '-', request()->path()) }}">
<div id="root">
    <x-web.ivnbg.partials.header />
     @if(isset($jumbotron) && !empty($jumbotron))
        <section>{{ $jumbotron }}</section>
    @endif
    <main class="container mx-auto mb-auto  p-6 mb-6">
        {{ $slot }}
    </main>
    @if(config('myapp.hasSupplementary'))
        <x-web.ivnbg.partials.supplementary />
    @endif

    <x-web.ivnbg.partials.footer />

</div>
@livewireScripts
</body>
</html>