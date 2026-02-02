<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Error')</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/' . config('myapp.project') . '/app.css', 'resources/js/app.js'])
    @else
        @vite(['resources/css/' . config('myapp.project') . '/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="flex items-center justify-center min-h-screen text-base bg-bcg-body">
<section class="text-center max-w-[600px]">
    <header class="flex justify-center mb-8">
        <x-utils.img-svg img="error" classList="logo [&>svg]:max-w-[300px] [&>svg]:max-h-[300px]" />
        {{-- <a href="{{ route('home') }}"> <span>{{ config('myapp.name') }}</span></a> --}}
    </header>
    <article>

        <h1 class="text-6xl text-danger">@yield('title', 'An Error Occurred')</h1>
        <div class="text-lg">
            @yield('content')
        </div>


    </article>

@if(app()->environment('local'))
        <h2 class="mt-8">@yield('code', 'Error')</h2>
        <div>
            {{ $exception->getMessage() }}
        </div>
    @endif
</section>
</body>
</html>