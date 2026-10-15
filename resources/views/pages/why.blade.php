@extends('layouts.site')

@section('title', __('site.nav.why').' — '.config('app.name'))
@section('body_class', 'bg-beige-500')

@section('content')
    @php
        $whyCms = cms_page('why');
        $bannerVideo = 'videos/cultura.mov';
        $saboresVideo = 'videos/gastronomia.mov';
        $culturaVideo = 'videos/cultura.mov';

        $heroTitle = $whyCms->text('hero.title', 'site.why_page.hero_title');
        $airEyebrow = $whyCms->text('air.eyebrow', 'site.why_page.air_eyebrow');
        $airTitle = $whyCms->text('air.title', 'site.why_page.air_title');
        $airText = $whyCms->text('air.text', 'site.why_page.air_text');
        $landEyebrow = $whyCms->text('land.eyebrow', 'site.why_page.land_eyebrow');
        $landTitle = $whyCms->text('land.title', 'site.why_page.land_title');
        $landText = $whyCms->text('land.text', 'site.why_page.land_text');
        $landText2 = $whyCms->text('land.text_2', 'site.why_page.land_text_2');
        $attractionsTitle = $whyCms->text('attractions.title', 'site.why_page.attractions_title');
        $attractionsText = $whyCms->text('attractions.text', 'site.why_page.attractions_text');
        $attractionsCta = $whyCms->text('attractions.cta', 'site.why_page.attractions_cta');
        $haciendasEyebrow = $whyCms->text('haciendas.eyebrow', 'site.why_page.haciendas_eyebrow');
        $haciendasTitle = $whyCms->text('haciendas.title', 'site.why_page.haciendas_title');
        $haciendasText = $whyCms->text('haciendas.text', 'site.why_page.haciendas_text');
        $haciendasCta = $whyCms->text('haciendas.cta', 'site.why_page.haciendas_cta');
        $venuesEyebrow = $whyCms->text('venues.eyebrow', 'site.why_page.venues_eyebrow');
        $venuesTitle = $whyCms->text('venues.title', 'site.why_page.venues_title');
        $venuesText = $whyCms->text('venues.text', 'site.why_page.venues_text');
        $venuesCta = $whyCms->text('venues.cta', 'site.why_page.venues_cta');
        $saboresTitle = $whyCms->text('sabores.title', 'site.why_page.sabores_title');
        $saboresText = $whyCms->text('sabores.text', 'site.why_page.sabores_text');
        $saboresCta = $whyCms->text('sabores.cta', 'site.why_page.sabores_cta');
        $culturaEyebrow = $whyCms->text('cultura.eyebrow', 'site.why_page.cultura_eyebrow');
        $culturaTitle = $whyCms->text('cultura.title', 'site.why_page.cultura_title');
        $culturaText = $whyCms->text('cultura.text', 'site.why_page.cultura_text');
        $culturaText2 = $whyCms->text('cultura.text_2', 'site.why_page.cultura_text_2');
        $culturaCta = $whyCms->text('cultura.cta', 'site.why_page.cultura_cta');
        $footerHeroTitle = $whyCms->text('footer.title', 'site.why_page.footer_hero_title');
        $footerHeroText = $whyCms->text('footer.text', 'site.why_page.footer_hero_text');

        $airCitiesLeft = $whyCms->enabled() && $whyCms->list('air.cities_left') !== []
            ? $whyCms->list('air.cities_left')
            : __('site.why_page.air_cities_left');
        $airCitiesRight = $whyCms->enabled() && $whyCms->list('air.cities_right') !== []
            ? $whyCms->list('air.cities_right')
            : __('site.why_page.air_cities_right');

        $venues = collect(__('site.why_page.venues'))
            ->values()
            ->map(function (array $item, int $index) {
                return [
                    ...$item,
                    'image' => $item['image'] ?? 'images/why-yucatan/grid/Image Placeholder ('.(11 + ($index % 6)).').png',
                    'icon' => 'images/svg/casita.svg',
                ];
            })
            ->all();

        $haciendas = collect(__('site.why_page.haciendas'))
            ->values()
            ->map(function (array $item, int $index) {
                return [
                    ...$item,
                    'image' => $item['image'] ?? 'images/why-yucatan/grid/Image Placeholder ('.(11 + (($index + 2) % 6)).').png',
                    'icon' => 'images/svg/casita.svg',
                ];
            })
            ->all();

        if ($whyCms->enabled()) {
            $cmsVenues = $whyCms->list('venues.items');
            if ($cmsVenues !== []) {
                $venues = collect($cmsVenues)
                    ->values()
                    ->map(function (array $item, int $index) {
                        return [
                            'name' => $item['name'] ?? '',
                            'image' => $item['image'] ?? 'images/why-yucatan/grid/Image Placeholder ('.(11 + ($index % 6)).').png',
                            'icon' => 'images/svg/casita.svg',
                        ];
                    })
                    ->filter(fn (array $item) => filled($item['name']))
                    ->values()
                    ->all();
            }

            $cmsHaciendas = $whyCms->list('haciendas.items');
            if ($cmsHaciendas !== []) {
                $haciendas = collect($cmsHaciendas)
                    ->values()
                    ->map(function (array $item, int $index) {
                        return [
                            'name' => $item['name'] ?? '',
                            'image' => $item['image'] ?? 'images/why-yucatan/grid/Image Placeholder ('.(11 + (($index + 2) % 6)).').png',
                            'icon' => 'images/svg/casita.svg',
                        ];
                    })
                    ->filter(fn (array $item) => filled($item['name']))
                    ->values()
                    ->all();
            }
        }

        $attractionIcons = [
            'images/iconos/Nuevos iconos (1).svg',
            'images/iconos/Nuevos iconos.svg',
            'images/iconos/Nuevos iconos (3).svg',
            'images/iconos/Nuevos iconos (4).svg',
            'images/iconos/Nuevos iconos (5).svg',
            'images/iconos/Nuevos iconos (6).svg',
        ];

        $attractions = collect(__('site.why_page.attractions'))
            ->values()
            ->map(function (array $item, int $index) use ($attractionIcons) {
                return [
                    ...$item,
                    'image' => 'images/atracciones/Image Placeholder ('.(8 + $index).').png',
                    'icon' => $attractionIcons[$index] ?? $attractionIcons[0],
                ];
            })
            ->all();

        if ($whyCms->enabled()) {
            $cmsAttractions = $whyCms->list('attractions.items');
            if ($cmsAttractions !== []) {
                $attractions = collect($cmsAttractions)
                    ->values()
                    ->map(function (array $item, int $index) use ($attractionIcons) {
                        return [
                            'name' => $item['name'] ?? '',
                            'image' => 'images/atracciones/Image Placeholder ('.(8 + $index).').png',
                            'icon' => $attractionIcons[$index] ?? $attractionIcons[0],
                        ];
                    })
                    ->filter(fn (array $item) => filled($item['name']))
                    ->values()
                    ->all();
            }
        }

    @endphp

    <main class="bg-beige-500 text-black-900">
        {{-- 1. Hero video --}}
        <section
            class="relative flex h-[calc(100svh-90px)] min-h-[calc(100svh-90px)] flex-col overflow-hidden bg-black-900"
            aria-labelledby="why-hero-title"
        >
            <video
                class="absolute inset-0 h-full w-full object-cover"
                autoplay
                muted
                loop
                playsinline
                aria-hidden="true"
            >
                <source src="{{ asset($bannerVideo) }}" type="video/mp4">
                <source src="{{ asset($bannerVideo) }}" type="video/quicktime">
            </video>

            <div class="absolute inset-0 bg-black-900/35" aria-hidden="true"></div>

            <div class="relative z-10 mx-auto mt-auto flex w-full max-w-site flex-col items-center gap-[30px] px-6 pb-12 pt-24 text-center lg:px-10 lg:pb-16">
                <img
                    src="{{ asset('images/svg/footerhero.svg') }}"
                    alt=""
                    class="block h-auto w-16 md:w-20"
                    width="80"
                    height="50"
                    aria-hidden="true"
                >

                <h1 id="why-hero-title" class="m-0 whitespace-pre-line text-h2 uppercase text-beige-100">{{ trim($heroTitle) }}</h1>
            </div>
        </section>

        {{-- 2. Conectividad aérea --}}
        <section class="bg-beige-500 py-16 lg:py-24" aria-labelledby="why-air-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-[minmax(0,0.7fr)_minmax(0,0.3fr)] lg:gap-12">
                    <div class="overflow-hidden">
                        <img
                            src="{{ asset('images/pqyucatan/Frame 132.png') }}"
                            alt="{{ __('site.why_page.air_map_alt') }}"
                            class="h-auto w-full object-contain"
                        >
                    </div>

                    <div class="text-left text-black-900">
                        <p class="text-btn3 font-book uppercase tracking-[0.04em] text-black-900">
                            {{ $airEyebrow }}
                        </p>

                        <h2 id="why-air-title" class="mt-3 text-s2 lg:text-s1">
                            {{ $airTitle }}
                        </h2>

                        <p class="mt-3 text-b2 font-book text-black-900">
                            {{ $airText }}
                        </p>

                        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-1 sm:grid-cols-2">
                            <ul class="list-disc space-y-1 pl-5 text-b2 font-book text-black-900">
                                @foreach ($airCitiesLeft as $city)
                                    <li>{{ $city }}</li>
                                @endforeach
                            </ul>
                            <ul class="list-disc space-y-1 pl-5 text-b2 font-book text-black-900">
                                @foreach ($airCitiesRight as $city)
                                    <li>{{ $city }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 3. Conectividad terrestre --}}
        <section class="bg-green-300 py-16 lg:py-24" aria-labelledby="why-land-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-[minmax(0,0.3fr)_minmax(0,0.7fr)] lg:gap-12">
                    <div class="text-left text-black-900">
                        <p class="text-btn3 font-book uppercase tracking-[0.04em] text-black-900">
                            {{ $landEyebrow }}
                        </p>

                        <h2 id="why-land-title" class="mt-3 text-s2 lg:text-s1">
                            {{ $landTitle }}
                        </h2>

                        <p class="mt-3 text-b2 font-book text-black-900">
                            {{ $landText }}
                        </p>

                        <p class="mt-3 text-b2 font-book text-black-900">
                            {{ $landText2 }}
                        </p>

                        <img
                            src="{{ asset('images/pqyucatan/Gifo (1).svg') }}"
                            alt=""
                            class="mt-8 h-14 w-auto lg:mt-10 lg:h-16"
                            height="64"
                            aria-hidden="true"
                        >
                    </div>

                    <div class="overflow-hidden">
                        <img
                            src="{{ asset('images/pqyucatan/Rectangle 3 (3).png') }}"
                            alt="{{ __('site.why_page.land_map_alt') }}"
                            class="h-auto w-full object-contain"
                        >
                    </div>
                </div>
            </div>
        </section>

        {{-- 4. Atractivos turísticos --}}
        <section class="bg-beige-500 py-16 lg:py-24" aria-labelledby="why-attractions-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="mx-auto max-w-3xl text-center text-black-900">
                    <h2 id="why-attractions-title" class="text-s1">
                        {{ $attractionsTitle }}
                    </h2>
                    <p class="mt-3 text-b2 font-book text-black-900">
                        {{ $attractionsText }}
                    </p>
                    <div class="mt-6">
                        <x-button variant="tertiary" class="border-black-900 bg-transparent" href="{{ route('pages.allies') }}">
                            {{ $attractionsCta }}
                        </x-button>
                    </div>
                </div>

                <ul class="mt-10 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:mt-12 lg:grid-cols-3 lg:gap-6">
                    @foreach ($attractions as $attraction)
                        <li class="overflow-hidden rounded-[8px] bg-beige-100">
                            <img
                                src="{{ asset($attraction['image']) }}"
                                alt="{{ $attraction['name'] }}"
                                class="aspect-[4/3] w-full object-cover"
                            >
                            <div class="relative flex min-h-[72px] items-center px-4 py-4 pr-12">
                                <p class="text-b1 font-bold text-black-900">
                                    {{ $attraction['name'] }}
                                </p>
                                <span
                                    class="absolute top-1/2 right-4 size-6 -translate-y-1/2 shrink-0 bg-black-900 [mask-image:var(--attraction-icon)] [mask-position:center] [mask-repeat:no-repeat] [mask-size:contain] [-webkit-mask-image:var(--attraction-icon)] [-webkit-mask-position:center] [-webkit-mask-repeat:no-repeat] [-webkit-mask-size:contain]"
                                    style="--attraction-icon: url('{{ asset($attraction['icon']) }}')"
                                    aria-hidden="true"
                                ></span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        {{-- 5. Haciendas --}}
        @include('partials.places-carousel', [
            'titleId' => 'why-haciendas-title',
            'eyebrow' => $haciendasEyebrow,
            'title' => $haciendasTitle,
            'text' => $haciendasText,
            'cta' => $haciendasCta,
            'ctaHref' => route('pages.allies'),
            'items' => $haciendas,
            'sectionBg' => 'bg-yellow-500',
            'footerBg' => 'bg-yellow-100',
            'navBtnClass' => 'bg-beige-100 text-black-900 hover:bg-black-900 hover:text-beige-100',
            'imageAspect' => 'aspect-square',
            'prevLabel' => __('site.why_page.carousel_prev'),
            'nextLabel' => __('site.why_page.carousel_next'),
            'carouselLabel' => __('site.why_page.haciendas_carousel'),
        ])

        {{-- 6. Venues --}}
        @include('partials.places-carousel', [
            'titleId' => 'why-venues-title',
            'eyebrow' => $venuesEyebrow,
            'title' => $venuesTitle,
            'text' => $venuesText,
            'cta' => $venuesCta,
            'ctaHref' => route('pages.allies'),
            'items' => $venues,
            'sectionBg' => 'bg-beige-500',
            'footerBg' => 'bg-beige-100',
            'imageAspect' => 'aspect-[4/5]',
            'prevLabel' => __('site.why_page.carousel_prev'),
            'nextLabel' => __('site.why_page.carousel_next'),
            'carouselLabel' => __('site.why_page.venues_carousel'),
        ])

        {{-- 7. Sabores / sección naranja con video --}}
        <section class="relative overflow-hidden bg-orange-300 py-16 max-md:overflow-visible md:bg-beige-500 lg:py-24" aria-labelledby="why-sabores-title">
            <div class="pointer-events-none absolute inset-0 z-0 hidden md:flex md:flex-col" aria-hidden="true">
                <div class="relative z-10 shrink-0 overflow-hidden leading-none">
                    <div class="flex w-max animate-cintilla-overlap will-change-transform">
                        <img
                            src="{{ asset('images/home/section6/fondonaranja.svg') }}"
                            alt=""
                            class="block h-auto w-[100vw] max-w-none shrink-0"
                            width="1919"
                            height="683"
                        >
                        <img
                            src="{{ asset('images/home/section6/fondonaranja.svg') }}"
                            alt=""
                            class="relative -ml-4 block h-auto w-[100vw] max-w-none shrink-0"
                            width="1919"
                            height="683"
                        >
                    </div>
                </div>
                <div class="relative z-0 -mt-4 min-h-0 flex-1 bg-orange-300"></div>
            </div>

            <div
                class="pointer-events-none absolute inset-x-0 -top-3 z-0 h-6 md:hidden"
                style="background-image: radial-gradient(circle at 12px 0, var(--color-beige-500) 11.5px, transparent 12px); background-size: 24px 24px; background-repeat: repeat-x;"
                aria-hidden="true"
            ></div>

            <div class="relative z-10 mx-auto max-w-site px-6 lg:px-10">
                <div class="mx-auto max-w-3xl text-center text-black-900">
                    <h2 id="why-sabores-title" class="text-s1">
                        {{ $saboresTitle }}
                    </h2>
                    <p class="mt-3 text-b2 font-book text-black-900">
                        {{ $saboresText }}
                    </p>
                </div>

                <div class="mx-auto mt-10 max-w-[1500px] overflow-hidden rounded-[8px] lg:mt-12">
                    <video
                        class="aspect-[1500/600] w-full object-cover"
                        autoplay
                        muted
                        loop
                        playsinline
                        aria-label="{{ $saboresTitle }}"
                    >
                        <source src="{{ asset($saboresVideo) }}" type="video/mp4">
                        <source src="{{ asset($saboresVideo) }}" type="video/quicktime">
                    </video>
                </div>

                <div class="mt-8 flex justify-center lg:mt-10">
                    <x-button variant="tertiary" class="border-black-900 bg-transparent" href="{{ route('pages.allies') }}">
                        {{ $saboresCta }}
                    </x-button>
                </div>
            </div>
        </section>

        {{-- 7. Cultura Maya --}}
        <section class="bg-beige-500 py-16 lg:py-24" aria-labelledby="why-cultura-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-[minmax(0,0.7fr)_minmax(0,0.3fr)] lg:gap-12">
                    <div class="overflow-hidden rounded-[8px]">
                        <video
                            class="aspect-[16/10] w-full object-cover"
                            autoplay
                            muted
                            loop
                            playsinline
                            aria-label="{{ $culturaTitle }}"
                        >
                            <source src="{{ asset($culturaVideo) }}" type="video/mp4">
                            <source src="{{ asset($culturaVideo) }}" type="video/quicktime">
                        </video>
                    </div>

                    <div class="text-left text-black-900">
                        <p class="text-btn3 font-book uppercase tracking-[0.04em] text-black-900">
                            {{ $culturaEyebrow }}
                        </p>

                        <h2 id="why-cultura-title" class="mt-3 text-s2 lg:text-s1">
                            {{ $culturaTitle }}
                        </h2>

                        <p class="mt-3 text-b2 font-book text-black-900">
                            {{ $culturaText }}
                        </p>

                        <p class="mt-3 text-b2 font-book text-black-900">
                            {{ $culturaText2 }}
                        </p>

                        <div class="mt-6">
                            <x-button variant="tertiary" class="border-black-900 bg-transparent" href="#why-attractions-title">
                                {{ $culturaCta }}
                            </x-button>
                        </div>

                        <img
                            src="{{ asset('images/home/section6/iconosuperior.svg') }}"
                            alt=""
                            class="mt-8 h-12 w-auto lg:mt-10 lg:h-14"
                            height="56"
                            aria-hidden="true"
                        >
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

@section('footer')
    <x-site-footer
        :hero-title="$footerHeroTitle"
        :hero-text="$footerHeroText"
    />
@endsection
