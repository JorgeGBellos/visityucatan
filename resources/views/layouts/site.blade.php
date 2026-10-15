<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name'))</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body @class(['min-h-screen antialiased font-sans text-black-900 pt-[90px]', trim($__env->yieldContent('body_class')) ?: 'bg-beige-300'])>
        <x-site-header />

        @yield('content')

        @if (trim($__env->yieldContent('footer_mode')) === 'none')
            {{-- Página sin site-footer (p. ej. confirmación) --}}
        @elseif ($__env->hasSection('footer'))
            @yield('footer')
        @else
            <x-site-footer />
        @endif
    </body>
</html>
