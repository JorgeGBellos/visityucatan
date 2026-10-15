@extends('layouts.site')

@section('title', __('site.nav.districts').' — '.config('app.name'))
@section('body_class', 'bg-yellow-500')

@section('footer')
    <x-site-footer :show-hero="false" background="yellow" />
@endsection

@section('content')
    @php
        $districtsCms = cms_page('districts');

        $heroTitle = $districtsCms->text('hero.title', 'site.districts_page.title');
        $heroSubtitle = $districtsCms->text('hero.subtitle', 'site.districts_page.subtitle');

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
    @endphp

    <main class="bg-yellow-500 text-black-900">
        <section class="py-16 lg:py-24" aria-labelledby="distritos-page-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="mx-auto max-w-3xl text-center text-black-900">
                    <img
                        src="{{ asset('images/svg/pajaronegro.svg') }}"
                        alt=""
                        class="mx-auto h-auto w-[70px] lg:w-[100px]"
                        width="100"
                        aria-hidden="true"
                    >

                    <h1 id="distritos-page-title" class="mt-6 text-s1 lg:text-h3">
                        {{ $heroTitle }}
                    </h1>

                    <p class="mt-2 text-b2 font-book text-black-900">
                        {{ $heroSubtitle }}
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

                            <div
                                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black-900/80 via-black-900/35 to-transparent transition-opacity duration-500 ease-out max-lg:opacity-0 lg:opacity-100 lg:group-hover:opacity-0 lg:group-focus-within:opacity-0"
                                aria-hidden="true"
                            ></div>

                            <div
                                class="pointer-events-none absolute inset-0 bg-black-900/55 transition-opacity duration-500 ease-out max-lg:opacity-100 lg:opacity-0 lg:group-hover:opacity-100 lg:group-focus-within:opacity-100"
                                aria-hidden="true"
                            ></div>

                            <div class="absolute inset-x-0 bottom-0 z-10 flex flex-col items-center px-6 pb-6 pt-16 text-center sm:pb-8">
                                <img
                                    src="{{ asset($distrito['icon']) }}"
                                    alt=""
                                    class="h-10 w-auto shrink-0"
                                    height="40"
                                    aria-hidden="true"
                                >

                                <h2 class="mt-3 text-s1 text-beige-100 sm:mt-4">
                                    {{ $distrito['title'] }}
                                </h2>

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
    </main>
@endsection
