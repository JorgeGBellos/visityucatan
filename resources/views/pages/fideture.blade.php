@extends('layouts.site')

@section('title', __('site.nav.fideture').' — '.config('app.name'))
@section('body_class', 'bg-beige-500')

@section('content')
    @php
        $fidetureCms = cms_page('fideture');

        $heroTitle = $fidetureCms->text('hero.title', 'site.fideture_page.hero_title');
        $heroText = $fidetureCms->text('hero.text', 'site.fideture_page.hero_text');
        $backgroundImage = $fidetureCms->image('hero.image', 'images/home/Frame 106.png');
    @endphp

    <main
        class="relative flex min-h-[calc(100svh-90px)] flex-col overflow-hidden bg-black-900"
        aria-labelledby="fideture-page-title"
    >
        <img
            src="{{ cms_asset($backgroundImage) }}"
            alt=""
            class="absolute inset-0 h-full w-full object-cover"
            aria-hidden="true"
        >

        <div class="absolute inset-0 bg-[#811C3F]/55" aria-hidden="true"></div>

        <div class="relative z-10 mx-auto flex w-full max-w-site flex-1 flex-col items-center justify-between px-6 py-12 text-center text-beige-100 lg:px-10 lg:py-16">
            <div class="flex w-full flex-1 flex-col items-center justify-center">
                <img
                    src="{{ asset('images/iconos/Fideture.svg') }}"
                    alt="Fideture"
                    class="h-auto w-[220px] sm:w-[280px] md:w-[335px]"
                    width="335"
                    height="40"
                >

                <div class="mt-6 flex max-w-3xl flex-col items-center gap-4 md:mt-8">
                    <h1 id="fideture-page-title" class="text-s2 text-beige-100 md:text-s1">
                        {{ $heroTitle }}
                    </h1>

                    <p class="max-w-2xl text-b2 font-book text-beige-100/95">
                        {{ $heroText }}
                    </p>
                </div>
            </div>

            <img
                src="{{ asset('images/logotipos/yucatan-fideture.svg') }}"
                alt="{{ __('site.fideture_page.gov_banner_alt') }}"
                class="mt-10 h-auto w-[140px] shrink-0 md:w-[170px]"
                width="170"
            >
        </div>
    </main>
@endsection
