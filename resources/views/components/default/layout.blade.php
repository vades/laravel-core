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
    <x-shared.gtag />

    @php
        $projectSlug = config('myapp.projectSlug');
        $customCssPath = resource_path("css/{$projectSlug}/app.css");
        $cssToLoad = file_exists($customCssPath)
            ? "resources/css/{$projectSlug}/app.css"
            : "resources/css/default/app.css";
    @endphp
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite([$cssToLoad, 'resources/js/app.js'])
    @else
        @vite([$cssToLoad, 'resources/js/app.js'])
    @endif
   {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>--}}
</head>
<body class="{{ str_replace('/', '-', request()->path()) }}">
<div id="root" class="min-h-screen flex flex-col">
    <x-default.partials.header />
     @if(isset($jumbotron) && !empty($jumbotron))
        <section>{{ $jumbotron }}</section>
    @endif
    <main class="container mx-auto mb-auto  p-6 mb-6">
        {{ $slot }}
    </main>
    @if(config('myapp.hasSupplementary'))
        <x-default.partials.supplementary />
    @endif

    <x-default.partials.footer />

</div>
@livewireScripts
</body>
</html>