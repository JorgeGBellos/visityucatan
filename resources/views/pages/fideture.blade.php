@extends('layouts.site')

@section('title', __('site.nav.fideture').' — '.config('app.name'))
@section('body_class', 'bg-beige-500')

@section('content')
    @php
        $fidetureCms = cms_page('fideture');

        $heroTitle = $fidetureCms->text('hero.title', 'site.fideture_page.hero_title');
        $heroText = $fidetureCms->text('hero.text', 'site.fideture_page.hero_text');
        $heroCta = $fidetureCms->text('hero.cta', 'site.fideture_page.hero_cta');
        $heroCtaUrl = $fidetureCms->text('hero.cta_url', 'site.fideture_page.about_cta_url');
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

                <a
                    href="{{ $heroCtaUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn btn-sm mt-8 inline-flex w-full max-w-xs items-center justify-center gap-2 border-beige-100 bg-beige-100 text-[#811C3F] hover:border-black-900 hover:bg-black-900 hover:text-beige-100 sm:w-auto sm:max-w-none"
                >
                    <span>{{ $heroCta }}</span>
                    <svg class="btn-icon" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M4 12L12 4M12 4H6.5M12 4V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
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
