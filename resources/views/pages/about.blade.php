@extends('layouts.site')

@section('title', __('site.nav.about').' — '.config('app.name'))
@section('body_class', 'bg-beige-500')

@section('content')
    @php
        $aboutCms = cms_page('about');
        $bannerVideo = 'videos/nosotros.mov';

        $heroTitle = $aboutCms->text('hero.title', 'site.about_page.hero_title');
        $visitTitle = $aboutCms->text('visit.title', 'site.about_page.visit_title');
        $visitText = $aboutCms->text('visit.text', 'site.about_page.visit_text');
        $visitText2 = $aboutCms->text('visit.text_2', 'site.about_page.visit_text_2');
        $teamTitle = $aboutCms->text('team.title', 'site.about_page.team_title');
        $teamText = $aboutCms->text('team.text', 'site.about_page.team_text');
        $teamText2 = $aboutCms->text('team.text_2', 'site.about_page.team_text_2');

        $recognitionLogos = [
            'images/Logos/Reconocimientos/premios heel.png',
            'images/Logos/Reconocimientos/dmo.png',
            'images/Logos/Reconocimientos/certificación Fideture.png',
            'images/Logos/Reconocimientos/leed.png',
            'images/Logos/Reconocimientos/mdc.png',
            'images/Logos/Reconocimientos/latinoamerica convenciones premio.png',
        ];

        $teamIcons = [
            'images/iconos/Nuevos iconos (1).svg',
            'images/iconos/Nuevos iconos.svg',
            'images/iconos/Nuevos iconos (3).svg',
            'images/iconos/Nuevos iconos (4).svg',
            'images/iconos/Nuevos iconos (5).svg',
            'images/iconos/Nuevos iconos (6).svg',
            'images/iconos/Nuevos iconos (8).svg',
            'images/iconos/Nuevos iconos (9).svg',
            'images/iconos/Nuevos iconos (2).svg',
        ];

        $defaultTeam = collect(__('site.about_page.team_members'))
            ->values()
            ->map(function (array $member, int $index) use ($teamIcons) {
                return [
                    ...$member,
                    'icon' => $teamIcons[$index] ?? $teamIcons[0],
                ];
            })
            ->all();

        $teamMembers = $defaultTeam;
        if ($aboutCms->enabled()) {
            $cmsTeam = $aboutCms->list('team.members');
            if ($cmsTeam !== []) {
                $teamMembers = collect($cmsTeam)
                    ->values()
                    ->map(function (array $member, int $index) use ($teamIcons, $defaultTeam) {
                        return [
                            'name' => $member['name'] ?? '',
                            'role' => $member['role'] ?? '',
                            'image' => $member['image'] ?? ($defaultTeam[$index]['image'] ?? 'images/equipo/Beatriz Niño.png'),
                            'icon' => $teamIcons[$index] ?? $teamIcons[0],
                        ];
                    })
                    ->filter(fn (array $m) => filled($m['name']))
                    ->values()
                    ->all();
            }
        }
    @endphp

    <main class="bg-beige-500 text-black-900">
        {{-- Hero: video + título + reconocimientos --}}
        <section
            class="relative flex h-[calc(100svh-90px)] min-h-[calc(100svh-90px)] flex-col overflow-hidden bg-black-900"
            aria-labelledby="about-hero-title"
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

                {{-- Contenido pegado al tag: evita newline inicial con whitespace-pre-line --}}
                <h1 id="about-hero-title" class="m-0 whitespace-pre-line text-h2 uppercase text-beige-100">{{ trim($heroTitle) }}</h1>

                <ul
                    class="flex flex-wrap items-center justify-center gap-3 sm:gap-4 lg:gap-5"
                    aria-label="{{ __('site.about_page.recognitions_label') }}"
                >
                    @foreach ($recognitionLogos as $logo)
                        <li class="flex size-14 items-center justify-center sm:size-16 lg:size-[72px]">
                            <img
                                src="{{ asset($logo) }}"
                                alt=""
                                class="max-h-full max-w-full object-contain"
                            >
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        {{-- Sección 2: Visit Yucatán + SVGs amarillos --}}
        <section class="bg-beige-500 pt-12 pb-16 md:pt-20 md:pb-20 lg:pt-30 lg:pb-24" aria-labelledby="about-visit-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:items-center lg:gap-10">
                    <div class="hidden justify-self-start lg:block" aria-hidden="true">
                        <img
                            src="{{ asset('images/home/col1.svg') }}"
                            alt=""
                            class="h-[320px] w-auto max-w-full object-contain object-left"
                            width="486"
                            height="486"
                        >
                    </div>

                    <div class="flex h-full flex-col items-center justify-center px-2 text-center text-black-900">
                        <img
                            src="{{ asset('images/logotipos/visit-vertical.svg') }}"
                            alt="{{ config('app.name') }}"
                            class="h-auto w-[180px] md:w-[140px] lg:w-[260px]"
                            width="220"
                            height="66"
                        >

                        <h2 id="about-visit-title" class="sr-only">
                            {{ $visitTitle }}
                        </h2>

                        <p class="mt-6 max-w-sm font-display text-b2 font-medium text-black-900">
                            {{ $visitText }}
                        </p>

                        <p class="mt-4 max-w-sm text-b2 font-book text-black-900">
                            {{ $visitText2 }}
                        </p>
                    </div>

                    <div class="hidden justify-self-end lg:block" aria-hidden="true">
                        <img
                            src="{{ asset('images/home/col2.svg') }}"
                            alt=""
                            class="h-[320px] w-auto max-w-full object-contain object-right"
                            width="480"
                            height="480"
                        >
                    </div>
                </div>
            </div>
        </section>

        {{-- Sección 3: Carrusel del equipo --}}
        <section
            class="overflow-x-clip bg-green-300 py-16 lg:py-24"
            aria-labelledby="about-team-title"
            x-data="siteCarousel"
        >
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="grid grid-cols-1 items-stretch gap-8 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,2.1fr)] lg:gap-12">
                    <div class="flex flex-col items-start justify-center text-left text-black-900">
                        <img
                            src="{{ asset('images/svg/casita.svg') }}"
                            alt=""
                            class="h-10 w-auto lg:h-12"
                            height="48"
                            aria-hidden="true"
                        >

                        <h2 id="about-team-title" class="mt-5 text-s2 lg:mt-6 lg:text-s1">
                            {{ $teamTitle }}
                        </h2>

                        <p class="mt-3 max-w-md text-b2 font-book text-black-900">
                            {{ $teamText }}
                        </p>

                        <p class="mt-3 max-w-md text-b2 font-book text-black-900">
                            {{ $teamText2 }}
                        </p>

                        <div class="mt-8 flex items-center gap-3 lg:mt-10">
                            <button
                                type="button"
                                class="inline-flex size-11 items-center justify-center rounded-full bg-beige-100 text-black-900 transition hover:bg-black-900 hover:text-beige-100"
                                aria-label="{{ __('site.about_page.team_prev') }}"
                                x-on:click="slide(-1)"
                            >
                                <svg class="size-4" viewBox="0 0 18 12" fill="none" aria-hidden="true">
                                    <path d="M17 6H1M1 6L6.5 1M1 6L6.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <button
                                type="button"
                                class="inline-flex size-11 items-center justify-center rounded-full bg-beige-100 text-black-900 transition hover:bg-black-900 hover:text-beige-100"
                                aria-label="{{ __('site.about_page.team_next') }}"
                                x-on:click="slide(1)"
                            >
                                <svg class="size-4" viewBox="0 0 18 12" fill="none" aria-hidden="true">
                                    <path d="M1 6H17M17 6L11.5 1M17 6L11.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div
                        x-ref="track"
                        class="carousel-bleed-right flex cursor-grab gap-5 overflow-x-auto scroll-smooth pb-1 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden active:cursor-grabbing lg:gap-6"
                        role="list"
                        aria-label="{{ __('site.about_page.team_carousel') }}"
                        x-on:pointerdown="onPointerDown($event)"
                        x-on:pointermove="onPointerMove($event)"
                        x-on:pointerup="onPointerUp($event)"
                        x-on:pointercancel="onPointerUp($event)"
                        x-on:click.capture="onClickCapture($event)"
                    >
                        @foreach ($teamMembers as $member)
                            <article
                                data-card
                                role="listitem"
                                class="flex w-[calc(100%-1.5rem)] shrink-0 select-none flex-col overflow-hidden rounded-[8px] sm:w-[calc((100%-1.25rem)/1.6)] lg:w-[calc((100%-3rem)/2.4)]"
                            >
                                <img
                                    src="{{ cms_asset($member['image']) }}"
                                    alt="{{ $member['name'] }}"
                                    class="pointer-events-none h-[520px] w-full object-cover"
                                    draggable="false"
                                >

                                <div class="relative flex min-h-[112px] shrink-0 flex-col justify-center bg-green-100 px-4 py-4 pr-12">
                                    <div>
                                        <p class="text-b1 font-bold text-black-900">
                                            {{ $member['name'] }}
                                        </p>
                                        <p class="mt-1 line-clamp-2 text-b2 font-book text-black-900">
                                            {{ $member['role'] }}
                                        </p>
                                    </div>

                                    <span
                                        class="absolute top-4 right-4 size-6 shrink-0 bg-black-900 [mask-image:var(--team-icon)] [mask-position:center] [mask-repeat:no-repeat] [mask-size:contain] [-webkit-mask-image:var(--team-icon)] [-webkit-mask-position:center] [-webkit-mask-repeat:no-repeat] [-webkit-mask-size:contain]"
                                        style="--team-icon: url('{{ asset($member['icon']) }}')"
                                        aria-hidden="true"
                                    ></span>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        @include('partials.blog-carousel', [
            'titleId' => 'about-blog-carousel-title',
            'sectionClass' => 'py-16 lg:py-24',
        ])
    </main>
@endsection
