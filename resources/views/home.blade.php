@extends('layouts.site')

@section('title', config('app.name'))

@section('content')
    @php
    $homeCms = cms_page('home');

    $statsIcons = [
        'images/iconos/home/Nuevos iconos.svg',
        'images/iconos/home/Nuevos iconos (1).svg',
        'images/iconos/home/Nuevos iconos (2).svg',
        'images/iconos/home/Nuevos iconos (3).svg',
    ];

    $parseStatValue = function (string $value): array {
        if (preg_match('/^(\D*?)(\d+)(.*)$/u', $value, $m)) {
            return [
                'animated' => true,
                'count' => (int) $m[2],
                'prefix' => $m[1],
                'suffix' => $m[3],
                'pad' => strlen($m[2]),
            ];
        }

        return [
            'animated' => false,
            'count' => null,
            'prefix' => '',
            'suffix' => '',
            'pad' => 0,
        ];
    };

    $stats = collect(__('site.home.stats'))
        ->values()
        ->map(function ($item, int $index) use ($statsIcons, $parseStatValue) {
            $value = $item['value'] ?? ($item[0] ?? '');

            return [
                'value' => $value,
                'label' => $item['label'] ?? ($item[1] ?? ''),
                'icon' => $statsIcons[$index] ?? $statsIcons[0],
                ...$parseStatValue($value),
            ];
        })
        ->all();

    $servicioCards = collect(__('site.home.servicios'))
        ->values()
        ->map(function (array $item, int $index) {
            $n = $index + 1;

            return [
                ...$item,
                'image' => "images/home/section4/images/card-{$n}.png",
                'icon' => "images/home/section4/icons/icon-{$n}.svg",
            ];
        })
        ->all();

    $distritoTitles = __('site.home.distritos');
    $distritoDescriptions = __('site.home.distritos_descriptions');
    $distritos = [
        [
            'title' => $distritoTitles[0],
            'description' => $distritoDescriptions[0] ?? '',
            'image' => 'images/home/section6/distrito-cic.png',
            'icon' => 'images/home/section6/cic.svg',
            'href' => route('pages.distrito', 'cic'),
        ],
        [
            'title' => $distritoTitles[1],
            'description' => $distritoDescriptions[1] ?? '',
            'image' => 'images/home/section6/distrito-siglo.png',
            'icon' => 'images/home/section6/siglo21.svg',
            'href' => route('pages.distrito', 'siglo-xxi'),
        ],
    ];

    $heroTitle = $homeCms->text('hero.title', 'site.home.hero_title');

    $aboutText = $homeCms->text('about.text', 'site.home.about_text');
    $aboutText2 = $homeCms->text('about.text_2', 'site.home.about_text_2');
    $aboutCta = $homeCms->text('about.cta', 'site.home.about_cta');

    $serviciosTitle = $homeCms->text('servicios.title', 'site.home.servicios_title');
    $serviciosText = $homeCms->text('servicios.text', 'site.home.servicios_text');

    $patrocinioTitle = $homeCms->text('patrocinio.title', 'site.home.patrocinio_title');
    $patrocinioText = $homeCms->text('patrocinio.text', 'site.home.patrocinio_text');
    $patrocinioCta = $homeCms->text('patrocinio.cta', 'site.home.patrocinio_cta');
    $patrocinioIcons = [
        'images/home/section3/icon-3.svg',
        'images/home/section3/icon-1.svg',
        'images/iconos/home/Nuevos iconos.svg',
        'images/iconos/Nuevos iconos (9).svg',
        'images/home/section4/icons/icon-4.svg',
        'images/home/section4/icons/icon-5.svg',
    ];
    $patrocinioItems = collect(__('site.home.patrocinio_items'))
        ->values()
        ->map(fn (string $label, int $index) => [
            'label' => $label,
            'icon' => $patrocinioIcons[$index] ?? $patrocinioIcons[0],
        ])
        ->all();

    $distritosTitle = $homeCms->text('distritos.title', 'site.home.distritos_title');
    $distritosText = $homeCms->text('distritos.text', 'site.home.distritos_text');

    $aliadosTitle = $homeCms->text('aliados.title', 'site.home.aliados_title');
    $aliadosText = $homeCms->text('aliados.text', 'site.home.aliados_text');
    $aliados = \App\Models\Ally::query()
        ->published()
        ->newest()
        ->limit(6)
        ->get()
        ->map(fn (\App\Models\Ally $ally) => $ally->toCarouselItem())
        ->values()
        ->all();

    $mediosTitle = $homeCms->text('medios.title', 'site.home.medios_title');
    $mediosImage = 'images/home/presencia.svg';

    $fidetureTitle = $homeCms->text('fideture.title', 'site.home.fideture_title');
    $fidetureText = $homeCms->text('fideture.text', 'site.home.fideture_text');
    $fidetureCta = $homeCms->text('fideture.cta', 'site.home.fideture_cta');

    if ($homeCms->enabled()) {
        $cmsStats = $homeCms->list('stats');
        if ($cmsStats !== []) {
            $stats = collect($cmsStats)
                ->values()
                ->map(function (array $row, int $index) use ($statsIcons, $parseStatValue) {
                    $value = $row['line_1'] ?? '';

                    return [
                        'value' => $value,
                        'label' => $row['line_2'] ?? '',
                        'icon' => $statsIcons[$index] ?? $statsIcons[0],
                        ...$parseStatValue($value),
                    ];
                })
                ->filter(fn (array $stat) => filled($stat['value']) || filled($stat['label']))
                ->values()
                ->all();
        }

        $cmsServicios = $homeCms->list('servicios.items');
        if ($cmsServicios !== []) {
            $servicioCards = collect($cmsServicios)
                ->values()
                ->map(function (array $item, int $index) use ($homeCms) {
                    $n = $index + 1;

                    return [
                        'title' => $item['title'] ?? '',
                        'description' => $item['description'] ?? '',
                        'image' => $homeCms->mediaUrl($item['image'] ?? null, "images/home/section4/images/card-{$n}.png"),
                        'icon' => $homeCms->mediaUrl($item['icon'] ?? null, "images/home/section4/icons/icon-{$n}.svg"),
                    ];
                })
                ->all();
        }
    }
@endphp

    <main class="bg-beige-300">
        <div class="relative">
            <section
                class="relative flex h-[calc(100svh-90px)] min-h-[calc(100svh-90px)] flex-col overflow-hidden bg-black-900"
                aria-labelledby="home-hero-title"
            >
                <video
                    class="absolute inset-0 h-full w-full object-cover"
                    autoplay
                    muted
                    loop
                    playsinline
                    poster="{{ asset('images/home/hero.png') }}"
                    aria-hidden="true"
                >
                    <source src="{{ asset('videos/home.mov') }}" type="video/mp4">
                    <source src="{{ asset('videos/home.mov') }}" type="video/quicktime">
                </video>

                <div class="absolute inset-0 bg-black-900/35" aria-hidden="true"></div>

                {{-- Título anclado al fondo; en desktop el pb = 60px + mitad de la barra solapada --}}
                <div
                    class="relative z-10 mx-auto mt-auto flex w-full max-w-site flex-col items-center px-6 pb-[60px] text-center lg:px-10 md:[padding-bottom:calc(60px+(var(--home-stats-h,148px)/2))]"
                >
                    <div class="flex flex-col items-center gap-[30px]">
                        <img
                            src="{{ asset('images/svg/footerhero.svg') }}"
                            alt=""
                            class="block h-auto w-16 md:w-20"
                            width="80"
                            height="50"
                            aria-hidden="true"
                        >

                        {{-- Contenido pegado al tag: evita newline inicial con whitespace-pre-line --}}
                        <h1 id="home-hero-title" class="m-0 whitespace-pre-line text-h2 uppercase text-beige-100">{{ trim($heroTitle) }}</h1>
                    </div>
                </div>
            </section>

            {{-- Stats desktop: mitad dentro del hero, mitad sobre la siguiente sección --}}
            <div class="pointer-events-none absolute inset-x-0 bottom-0 z-20 hidden translate-y-1/2 justify-center px-6 md:flex lg:px-10">
                <ul
                    x-data
                    x-init="
                        const setH = () => {
                            const h = $el.getBoundingClientRect().height;
                            if (h > 0) document.documentElement.style.setProperty('--home-stats-h', `${h}px`);
                        };
                        $nextTick(setH);
                        new ResizeObserver(setH).observe($el);
                    "
                    class="pointer-events-auto flex w-full max-w-[1000px] items-stretch overflow-hidden rounded-2xl bg-green-700"
                    aria-label="{{ __('site.home.stats_aria') }}"
                >
                    @foreach ($stats as $index => $stat)
                        @if ($index > 0)
                            <li class="flex w-px shrink-0 items-stretch py-6" aria-hidden="true">
                                <span class="w-px bg-beige-100/80"></span>
                            </li>
                        @endif
                        <li class="flex flex-1 flex-col items-center justify-center gap-2 px-3 py-6 text-center sm:px-4">
                            <img
                                src="{{ asset($stat['icon']) }}"
                                alt=""
                                class="h-8 w-8 object-contain"
                                width="32"
                                height="32"
                                aria-hidden="true"
                            >
                            @if ($stat['animated'])
                                <p
                                    class="text-s2 leading-tight text-beige-100"
                                    x-data="statCounter({{ $stat['count'] }}, @js($stat['prefix']), @js($stat['suffix']), {{ $stat['pad'] }})"
                                    x-text="display"
                                >{{ $stat['value'] }}</p>
                            @else
                                <p class="text-s2 leading-tight text-beige-100">
                                    {{ $stat['value'] }}
                                </p>
                            @endif
                            <p class="text-b3 font-book leading-tight text-beige-100/90">
                                {{ $stat['label'] }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Stats móvil: grid 2x2 --}}
        <section class="bg-beige-500 px-6 py-8 md:hidden" aria-label="{{ __('site.home.stats_aria') }}">
            <ul class="grid grid-cols-2 gap-3">
                @foreach ($stats as $stat)
                    <li class="flex min-h-[7rem] flex-col items-center justify-center gap-2 rounded-2xl bg-green-700 px-3 py-5 text-center">
                        <img
                            src="{{ asset($stat['icon']) }}"
                            alt=""
                            class="h-7 w-7 object-contain"
                            width="28"
                            height="28"
                            aria-hidden="true"
                        >
                        @if ($stat['animated'])
                            <p
                                class="text-s2 leading-tight text-beige-100"
                                x-data="statCounter({{ $stat['count'] }}, @js($stat['prefix']), @js($stat['suffix']), {{ $stat['pad'] }})"
                                x-text="display"
                            >{{ $stat['value'] }}</p>
                        @else
                            <p class="text-s2 leading-tight text-beige-100">
                                {{ $stat['value'] }}
                            </p>
                        @endif
                        <p class="text-b3 font-book leading-tight text-beige-100/90">
                            {{ $stat['label'] }}
                        </p>
                    </li>
                @endforeach
            </ul>
        </section>

        <section class="bg-beige-500 pt-12 pb-16 md:pt-20 md:pb-20 lg:pt-30 lg:pb-24" aria-labelledby="about-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:items-center lg:gap-10">
                    {{-- Columna izquierda (solo desktop) --}}
                    <div class="hidden justify-self-start lg:block" aria-hidden="true">
                        <img
                            src="{{ asset('images/services/Frame 133.svg') }}"
                            alt=""
                            class="h-[320px] w-auto max-w-full object-contain object-left"
                            height="320"
                        >
                    </div>

                    {{-- Columna central --}}
                    <div class="flex h-full flex-col items-center justify-center px-2 text-center text-black-900">
                        <img
                            src="{{ asset('images/logotipos/visit-vertical.svg') }}"
                            alt="{{ config('app.name') }}"
                            class="h-auto w-[180px] md:w-[140px] lg:w-[260px]"
                            width="220"
                            height="66"
                        >

                        <h2 id="about-title" class="sr-only">
                            {{ __('site.home.about_title') }}
                        </h2>

                        <p class="mt-6 max-w-sm text-b2 font-bold text-black-900">
                            {{ $aboutText }}
                        </p>

                        <p class="mt-4 max-w-sm text-b2 font-bold text-black-900">
                            {{ $aboutText2 }}
                        </p>

                        <div class="mt-6">
                            <x-button variant="tertiary" class="border-black-900" href="{{ route('pages.about') }}">
                                {{ $aboutCta }}
                            </x-button>
                        </div>
                    </div>

                    {{-- Columna derecha (solo desktop) --}}
                    <div class="hidden justify-self-end lg:block" aria-hidden="true">
                        <img
                            src="{{ asset('images/services/Frame 134.svg') }}"
                            alt=""
                            class="h-[320px] w-auto max-w-full object-contain object-right"
                            height="320"
                        >
                    </div>
                </div>
            </div>
        </section>

        {{-- Sección Servicios --}}
        <section class="bg-green-300 py-16 lg:py-24" aria-labelledby="servicios-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="mx-auto max-w-3xl text-left text-black-900 lg:text-center">
                    <h2 id="servicios-title" class="text-s1">
                        {{ $serviciosTitle }}
                    </h2>
                    <p class="mt-2 text-b2 font-book text-black-700">
                        {{ $serviciosText }}
                    </p>
                </div>

                <ul class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:mt-12 lg:grid-cols-3 lg:gap-8">
                    @foreach ($servicioCards as $card)
                        <li class="overflow-hidden rounded-lg bg-beige-100">
                            <img
                                src="{{ cms_asset($card['image']) }}"
                                alt=""
                                class="aspect-[3/2] w-full object-cover"
                            >
                            <div class="flex items-start justify-between gap-3 px-4 pt-3 pb-4">
                                <div class="min-w-0 flex-1">
                                    <p class="text-b1 font-bold text-black-900">
                                        {{ $card['title'] }}
                                    </p>
                                    <p class="mt-1 text-b2 font-book text-black-700">
                                        {{ $card['description'] }}
                                    </p>
                                </div>
                                <span
                                    class="mt-0.5 size-6 shrink-0 bg-[#AAC17B] [mask-image:var(--servicio-icon)] [mask-position:center] [mask-repeat:no-repeat] [mask-size:contain] [-webkit-mask-image:var(--servicio-icon)] [-webkit-mask-position:center] [-webkit-mask-repeat:no-repeat] [-webkit-mask-size:contain]"
                                    style="--servicio-icon: url('{{ cms_asset($card['icon']) }}')"
                                    aria-hidden="true"
                                ></span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        {{-- Programa de patrocinio --}}
        <section class="bg-beige-500 py-16 lg:py-24" aria-labelledby="patrocinio-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="mx-auto max-w-3xl text-center text-black-900">
                    <h2 id="patrocinio-title" class="text-s1">
                        {{ $patrocinioTitle }}
                    </h2>
                    <p class="mt-3 text-b2 font-book text-black-700">
                        {{ $patrocinioText }}
                    </p>
                </div>

                <ul class="mt-10 grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4 lg:mt-12 lg:grid-cols-6 lg:gap-5">
                    @foreach ($patrocinioItems as $item)
                        <li class="flex flex-col items-center rounded-lg bg-beige-100 px-3 py-5 text-center sm:px-4 sm:py-6">
                            <span
                                class="size-[60px] shrink-0 bg-green-700 [mask-image:var(--patrocinio-icon)] [mask-position:center] [mask-repeat:no-repeat] [mask-size:contain] [-webkit-mask-image:var(--patrocinio-icon)] [-webkit-mask-position:center] [-webkit-mask-repeat:no-repeat] [-webkit-mask-size:contain]"
                                style="--patrocinio-icon: url('{{ asset($item['icon']) }}')"
                                aria-hidden="true"
                            ></span>
                            <p class="mt-4 text-b2 font-bold text-black-900">
                                {{ $item['label'] }}
                            </p>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-10 flex justify-center lg:mt-12">
                    <x-button
                        variant="tertiary"
                        class="border-black-900"
                        href="{{ route('pages.apoyos') }}"
                    >
                        {{ $patrocinioCta }}
                    </x-button>
                </div>
            </div>
        </section>

        {{-- Sección Distritos --}}
        <section class="relative overflow-hidden bg-orange-300 py-16 max-md:overflow-visible md:bg-beige-500 lg:py-24" aria-labelledby="distritos-title">
            {{-- SVG naranja animado (desktop): festón visible + naranja continuo detrás de los cards --}}
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
                {{-- Extensión del color del SVG para contener título + cards --}}
                <div class="relative z-0 -mt-4 min-h-0 flex-1 bg-orange-300"></div>
            </div>

            {{-- Orilla festoneada móvil (beige → naranja) --}}
            <div
                class="pointer-events-none absolute inset-x-0 -top-3 z-0 h-6 md:hidden"
                style="background-image: radial-gradient(circle at 12px 0, var(--color-beige-500) 11.5px, transparent 12px); background-size: 24px 24px; background-repeat: repeat-x;"
                aria-hidden="true"
            ></div>

            <div class="relative z-10 mx-auto max-w-site px-6 lg:px-10">
                <div class="mx-auto max-w-3xl text-left text-black-900 lg:text-center">
                    <img
                        src="{{ asset('images/home/section6/iconosuperior.svg') }}"
                        alt=""
                        class="mx-auto hidden h-auto w-[130px] lg:block"
                        width="130"
                        aria-hidden="true"
                    >

                    <h2 id="distritos-title" class="text-s1 lg:mt-6">
                        {{ $distritosTitle }}
                    </h2>

                    <p class="mt-2 text-b2 font-book text-black-700">
                        {{ $distritosText }}
                    </p>
                </div>

                <ul class="mt-10 grid grid-cols-1 gap-6 lg:mt-12 lg:grid-cols-2 lg:gap-8">
                    @foreach ($distritos as $distrito)
                        <li class="group relative aspect-[4/3] overflow-hidden rounded-lg">
                            <img
                                src="{{ asset($distrito['image']) }}"
                                alt="{{ $distrito['title'] }}"
                                class="absolute inset-0 size-full object-cover transition-transform duration-700 ease-out group-hover:scale-105 group-focus-within:scale-105"
                            >

                            {{-- Gradiente base (reposo en desktop) --}}
                            <div
                                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black-900/80 via-black-900/35 to-transparent transition-opacity duration-500 ease-out max-lg:opacity-0 lg:opacity-100 lg:group-hover:opacity-0 lg:group-focus-within:opacity-0"
                                aria-hidden="true"
                            ></div>

                            {{-- Overlay completo (hover / focus / móvil) --}}
                            <div
                                class="pointer-events-none absolute inset-0 bg-black-900/55 transition-opacity duration-500 ease-out max-lg:opacity-100 lg:opacity-0 lg:group-hover:opacity-100 lg:group-focus-within:opacity-100"
                                aria-hidden="true"
                            ></div>

                            {{-- Contenido anclado abajo (reposo y hover, como en la ref) --}}
                            <div class="absolute inset-x-0 bottom-0 z-10 flex flex-col items-center px-6 pb-6 pt-16 text-center sm:pb-8">
                                <img
                                    src="{{ asset($distrito['icon']) }}"
                                    alt=""
                                    class="h-10 w-auto shrink-0"
                                    height="40"
                                    aria-hidden="true"
                                >

                                <h3 class="mt-3 text-s1 text-beige-100 sm:mt-4">
                                    {{ $distrito['title'] }}
                                </h3>

                                <div class="grid w-full max-w-md grid-rows-[1fr] transition-[grid-template-rows] duration-500 ease-out lg:grid-rows-[0fr] lg:group-hover:grid-rows-[1fr] lg:group-focus-within:grid-rows-[1fr]">
                                    <div class="min-h-0 overflow-hidden">
                                        <p class="mt-3 text-b2 font-book text-beige-100/95 transition-opacity duration-500 ease-out delay-100 max-lg:opacity-100 lg:opacity-0 lg:group-hover:opacity-100 lg:group-focus-within:opacity-100">
                                            {{ $distrito['description'] }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 sm:mt-5">
                                    <x-button variant="secondary" size="sm" href="{{ $distrito['href'] }}">
                                        {{ __('site.common.explore_district') }}
                                    </x-button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        {{-- Ubicación de distritos --}}
        <section class="bg-beige-100 py-16 lg:py-24" aria-labelledby="distritos-ubicacion-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-[7fr_3fr] lg:gap-12">
                    <div class="overflow-hidden rounded-lg bg-beige-100">
                        <video
                            class="aspect-[4/3] h-full w-full object-cover lg:aspect-[5/4]"
                            autoplay
                            muted
                            loop
                            playsinline
                            aria-hidden="true"
                        >
                            <source src="{{ asset('videos/distritos-bloop.mp4') }}" type="video/mp4">
                            <source src="{{ asset('videos/Bloop distritos (1).mp4') }}" type="video/mp4">
                        </video>
                    </div>

                    <div class="flex flex-col text-black-900">
                        <h2 id="distritos-ubicacion-title" class="text-s1">
                            {{ __('site.home.distritos_ubicacion_title') }}
                        </h2>

                        <p class="mt-3 text-b2 font-book text-black-900">
                            {{ __('site.home.distritos_ubicacion_text') }}
                        </p>

                        <div class="mt-8">
                            <x-button
                                variant="tertiary"
                                class="border-black-900"
                                href="{{ route('pages.districts') }}"
                            >
                                {{ __('site.home.distritos_ubicacion_cta') }}
                            </x-button>
                        </div>

                        <div
                            class="mt-8 aspect-[4/3] overflow-hidden rounded-lg bg-black-100 sm:aspect-[16/10] lg:mt-10"
                            role="img"
                            aria-label="{{ __('site.home.distritos_ubicacion_map') }}"
                        >
                            <iframe
                                title="{{ __('site.home.distritos_ubicacion_map') }}"
                                class="h-full w-full border-0"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d119066.313542!2d-89.72!3d20.97!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f56715a5d6871f3%3A0xfce4fc80ecd26a0!2sM%C3%A9rida%2C%20Yuc.!5e0!3m2!1ses-419!2smx!4v1700000000000!5m2!1ses-419!2smx"
                                allowfullscreen
                            ></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('partials.aliados-carousel', [
            'aliados' => $aliados,
            'title' => $aliadosTitle,
            'text' => $aliadosText,
            'sectionClass' => 'py-16 lg:py-24',
            'sectionBg' => 'bg-beige-300',
        ])

        <section class="bg-beige-500 py-16 lg:py-24" aria-labelledby="medios-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <h2 id="medios-title" class="text-center text-s1 text-black-900">
                    {{ $mediosTitle }}
                </h2>

                <div class="mt-10 lg:mt-14">
                    <img
                        src="{{ asset($mediosImage) }}"
                        alt="{{ $mediosTitle }}"
                        class="mx-auto h-auto w-full max-w-[1542px] object-contain grayscale"
                        width="1542"
                        height="341"
                        loading="lazy"
                    >
                </div>
            </div>
        </section>

        @include('partials.fideture-block', [
            'title' => $fidetureTitle,
            'text' => $fidetureText,
            'cta' => $fidetureCta,
            'ctaHref' => route('pages.fideture'),
            'sectionClass' => 'py-16 lg:py-24',
            'backgroundImage' => 'images/home/Frame 106.png',
            'useRichText' => true,
        ])
    </main>
@endsection

@section('footer')
    <x-site-footer />
@endsection
