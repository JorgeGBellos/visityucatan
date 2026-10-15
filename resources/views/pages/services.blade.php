@extends('layouts.site')

@section('title', __('site.nav.services').' — '.config('app.name'))
@section('body_class', 'bg-beige-500')

@section('content')
    @php
        $stageIcons = [
            'images/iconos/Nuevos iconos (9).svg',
            'images/iconos/Nuevos iconos (5).svg',
            'images/iconos/Nuevos iconos (7).svg',
            'images/iconos/Nuevos iconos (2).svg',
            'images/iconos/Nuevos iconos (4).svg',
        ];

        $stageCards = collect(__('site.services_page.stages'))
            ->values()
            ->map(function (array $item, int $index) use ($stageIcons) {
                $n = $index + 3;

                return [
                    ...$item,
                    'image' => "images/services/Image Placeholder ({$n}).png",
                    'icon' => $stageIcons[$index] ?? $stageIcons[0],
                ];
            })
            ->all();

        $procesoSteps = collect(__('site.services_page.proceso'))
            ->values()
            ->map(function (array $item, int $index) {
                return [
                    ...$item,
                    'icon' => 'images/home/section5/icons/icon-'.($index + 1).'.svg',
                ];
            })
            ->all();

        $supportIcons = [
            'images/iconos/Nuevos iconos (2).svg',
            'images/iconos/Nuevos iconos (1).svg',
            'images/iconos/Nuevos iconos.svg',
            'images/iconos/Nuevos iconos (3).svg',
            'images/iconos/Nuevos iconos (6).svg',
            'images/iconos/Nuevos iconos (7).svg',
        ];

        $supportCards = collect(__('site.services_page.support'))
            ->values()
            ->map(function (array $item, int $index) use ($supportIcons) {
                $n = $index + 18;

                return [
                    ...$item,
                    'image' => "images/services/grid/Image Placeholder ({$n}).png",
                    'icon' => $supportIcons[$index] ?? $supportIcons[0],
                ];
            })
            ->all();
    @endphp

    <main class="bg-beige-500 text-black-900">
        {{-- Hero: SVGs laterales + copy centrado --}}
        <section
            class="relative flex min-h-0 items-center bg-beige-500 py-16 lg:min-h-[700px] lg:py-0"
            aria-labelledby="services-hero-title"
        >
            <div class="mx-auto w-full max-w-site px-6 lg:px-10">
                <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.35fr)_minmax(0,1fr)] lg:gap-8">
                    <div class="hidden justify-self-start lg:block" aria-hidden="true">
                        <img
                            src="{{ asset('images/services/Frame 133.svg') }}"
                            alt=""
                            class="h-[320px] w-auto max-w-full object-contain object-left"
                            height="320"
                        >
                    </div>

                    <div class="mx-auto flex max-w-xl flex-col items-center text-center text-black-900">
                        <h1 id="services-hero-title" class="text-s2 lg:text-s1">
                            {{ __('site.services_page.hero_title') }}
                        </h1>

                        <p class="mt-4 text-b2 font-book text-black-700">
                            {{ __('site.services_page.hero_text') }}
                        </p>

                        <div class="mt-8 flex flex-col items-center gap-4">
                            <x-button variant="tertiary" class="border-black-900" href="#servicios-etapas">
                                {{ __('site.services_page.hero_cta') }}
                            </x-button>

                            <a
                                href="#servicios-etapas"
                                class="animate-float inline-flex text-black-900 transition-opacity hover:opacity-70"
                                aria-label="{{ __('site.services_page.hero_cta') }}"
                            >
                                <svg class="size-5" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                    <path d="M10 4v11M10 15l-4-4M10 15l4-4" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>

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

        {{-- Etapas: grid 3 + 2 sobre green --}}
        <section id="servicios-etapas" class="bg-green-300 py-16 lg:py-24" aria-labelledby="servicios-etapas-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="mx-auto max-w-3xl text-center text-black-900">
                    <h2 id="servicios-etapas-title" class="text-s1">
                        {{ __('site.services_page.stages_title') }}
                    </h2>
                </div>

                <ul class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-6 lg:gap-8">
                    @foreach ($stageCards as $index => $card)
                        <li
                            @class([
                                'flex flex-col rounded-lg bg-beige-100 p-4 text-black-900 sm:col-span-1 lg:col-span-2',
                                'lg:col-start-2' => $index === 3,
                                'lg:col-start-4' => $index === 4,
                            ])
                        >
                            <div class="flex items-start justify-between gap-3 px-1">
                                <h3 class="text-s3">
                                    {{ $card['title'] }}
                                </h3>
                                <img
                                    src="{{ asset($card['icon']) }}"
                                    alt=""
                                    class="mt-0.5 size-6 shrink-0 object-contain"
                                    width="24"
                                    height="24"
                                    aria-hidden="true"
                                >
                            </div>

                            <p class="mt-2 px-1 text-b2 font-book text-black-700">
                                {{ $card['description'] }}
                            </p>

                            <a
                                href="#proceso"
                                class="mt-3 inline-flex items-center gap-1.5 px-1 text-btn3 uppercase tracking-wide text-black-900 transition-opacity hover:opacity-70"
                            >
                                <span>{{ __('site.services_page.see_more') }}</span>
                                <svg class="size-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                    <path d="M7 2.5v9M7 11.5L3.5 8M7 11.5L10.5 8" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>

                            <img
                                src="{{ asset($card['image']) }}"
                                alt=""
                                class="mt-4 aspect-[4/3] w-full rounded-lg object-cover"
                            >
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        {{-- Proceso: copy + 7 pasos --}}
        <section id="proceso" class="bg-beige-500 py-16 lg:py-24" aria-labelledby="proceso-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,1.4fr)] lg:gap-14">
                    <div class="text-black-900">
                        <h2 id="proceso-title" class="text-s1">
                            {{ __('site.services_page.proceso_title') }}
                        </h2>
                        <p class="mt-2 text-b2 font-book text-black-700">
                            {{ __('site.services_page.proceso_text') }}
                        </p>
                        <div class="mt-8">
                            <x-button variant="primary" href="{{ route('pages.plan') }}">
                                {{ __('site.common.plan_event') }}
                            </x-button>
                        </div>
                    </div>

                    <ul class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-4 md:gap-4">
                        @foreach ($procesoSteps as $step)
                            <li class="flex flex-col items-start rounded-lg bg-beige-100 px-3 py-6 text-left text-black-900">
                                <img
                                    src="{{ asset($step['icon']) }}"
                                    alt=""
                                    class="size-12 object-contain sm:size-[60px]"
                                    width="60"
                                    height="60"
                                    aria-hidden="true"
                                >
                                <p class="mt-4 text-label uppercase tracking-wide text-black-700">
                                    {{ $step['label'] }}
                                </p>
                                <p class="mt-2 text-s3">
                                    {{ $step['title'] }}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>

        {{-- Apoyos: grid 6 items sobre beige-300 --}}
        <section class="bg-beige-300 py-16 lg:py-24" aria-labelledby="servicios-apoyos-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between lg:gap-10">
                    <h2 id="servicios-apoyos-title" class="max-w-2xl text-s2 text-black-900 lg:text-s1">
                        {{ __('site.services_page.support_title') }}
                    </h2>

                    <x-button variant="primary" class="w-full shrink-0 lg:w-auto" href="{{ route('pages.plan') }}">
                        {{ __('site.common.plan_event') }}
                    </x-button>
                </div>

                <ul class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:mt-12 lg:grid-cols-3 lg:gap-8">
                    @foreach ($supportCards as $card)
                        <li class="overflow-hidden rounded-lg bg-white p-4 text-black-900">
                            <img
                                src="{{ asset($card['image']) }}"
                                alt=""
                                class="aspect-[4/3] w-full rounded-lg object-cover"
                            >
                            <div class="px-1 pt-3 pb-2">
                                <div class="flex items-start justify-between gap-3">
                                    <p class="text-b1 font-bold text-black-900">
                                        {{ $card['title'] }}
                                    </p>
                                    <img
                                        src="{{ asset($card['icon']) }}"
                                        alt=""
                                        class="size-6 shrink-0 object-contain"
                                        width="24"
                                        height="24"
                                        aria-hidden="true"
                                    >
                                </div>
                                <p class="mt-1 text-b2 font-book text-black-700">
                                    {{ $card['description'] }}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    </main>
@endsection
