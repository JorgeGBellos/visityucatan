@extends('layouts.site')

@section('title', __('site.nav.district_supports').' — '.config('app.name'))
@section('body_class', 'bg-beige-500')

@section('content')
    @php
        $bannerVideo = 'videos/eventos.mov';

        $apoyosCms = cms_page('apoyos');
        $isEnglish = app()->getLocale() === 'en';
        $biddingBookUrl = $apoyosCms->image(
            'bidding_book',
            $isEnglish ? 'files/bidding-book-en.pdf' : 'files/bidding-book-es.pdf',
        );
        $biddingBookName = $isEnglish ? 'Bidding-Book-Yucatan-ING.pdf' : 'Bidding-Book-Yucatan-ESP.pdf';
        $downloadCta = $apoyosCms->text('download.cta', 'site.apoyos_page.download_cta');
        $requestCta = $apoyosCms->text('request.cta', 'site.apoyos_page.request_info_cta');
        $programTitle = $apoyosCms->text('program.title', 'site.apoyos_page.program_title');
        $programText = $apoyosCms->text('program.text', 'site.apoyos_page.program_text');

        $cardMedia = [
            ['image' => 'images/apoyos/apoyo-1.png', 'icon' => 'images/home/patrocinio/apoyo-economico.png', 'tone' => 'bg-green-100'],
            ['image' => 'images/apoyos/apoyo-2.png', 'icon' => 'images/home/patrocinio/descuentos-recintos.png', 'tone' => 'bg-blue-100'],
            ['image' => 'images/apoyos/apoyo-6.png', 'icon' => 'images/home/patrocinio/espectaculos.png', 'tone' => 'bg-orange-100'],
            ['image' => 'images/apoyos/apoyo-5.png', 'icon' => 'images/home/patrocinio/aerolineas.png', 'tone' => 'bg-orange-100'],
            ['image' => 'images/apoyos/apoyo-4.png', 'icon' => 'images/home/patrocinio/vinculacion-turistica.png', 'tone' => 'bg-green-100'],
            ['image' => 'images/apoyos/apoyo-3.png', 'icon' => 'images/home/patrocinio/vinculacion-institucional.png', 'tone' => 'bg-blue-100'],
        ];

        $supportCards = collect($apoyosCms->list('items', __('site.apoyos_page.items')))
            ->values()
            ->map(function (array $item, int $index) use ($cardMedia) {
                return [
                    ...$item,
                    ...($cardMedia[$index] ?? $cardMedia[0]),
                ];
            })
            ->all();
    @endphp

    <main class="bg-beige-500 text-black-900">
        <section
            class="relative flex h-[calc(100svh-90px)] min-h-[calc(100svh-90px)] flex-col overflow-hidden bg-black-900"
            aria-label="{{ __('site.nav.district_supports') }}"
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

            <div class="relative z-10 mx-auto mt-auto flex w-full max-w-site flex-col items-center px-6 pb-10 pt-24 text-center lg:px-10 lg:pb-14">
                <a
                    href="{{ $biddingBookUrl }}"
                    download="{{ $biddingBookName }}"
                    class="btn btn-sm inline-flex items-center gap-2 border-beige-100 bg-beige-100 text-black-900 hover:border-black-900 hover:bg-black-900 hover:text-beige-100"
                >
                    <span>{{ $downloadCta }}</span>
                    <svg class="size-4 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M8 2.5v8M8 10.5L5 7.5M8 10.5L11 7.5M3 13.5h10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </section>

        <section class="bg-beige-300 py-16 lg:py-24" aria-labelledby="apoyos-program-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="mx-auto max-w-3xl text-center text-black-900">
                    <h2 id="apoyos-program-title" class="text-s1 uppercase">
                        {{ $programTitle }}
                    </h2>
                    <p class="mt-4 text-b2 font-book text-black-900 lg:mt-5">
                        {{ $programText }}
                    </p>
                </div>

                <ul class="mt-12 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:mt-16 lg:grid-cols-3 lg:gap-6">
                    @foreach ($supportCards as $card)
                        <li class="flex flex-col overflow-hidden rounded-2xl {{ $card['tone'] }} text-center text-black-900">
                            <div class="flex flex-1 flex-col px-5 pt-8 sm:px-6 sm:pt-10">
                                <img
                                    src="{{ asset($card['icon']) }}"
                                    alt=""
                                    class="mx-auto size-12 shrink-0 object-contain lg:size-14"
                                    width="56"
                                    height="56"
                                    aria-hidden="true"
                                >

                                <h3 class="mt-5 text-b1 font-bold text-black-900 lg:mt-6">
                                    {{ $card['title'] }}
                                </h3>

                                <p class="mt-2 flex-1 text-b2 font-book text-black-900">
                                    {{ $card['description'] }}
                                </p>
                            </div>

                            <div class="px-4 pb-4 pt-6 sm:px-5 sm:pb-5 sm:pt-8">
                                <img
                                    src="{{ asset($card['image']) }}"
                                    alt=""
                                    class="aspect-[4/3] w-full rounded-xl object-cover"
                                >
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:mt-12 sm:flex-row sm:gap-5 lg:mt-14">
                    <x-button variant="primary" href="{{ route('pages.plan') }}">
                        {{ $requestCta }}
                    </x-button>

                    <a
                        href="{{ $biddingBookUrl }}"
                        download="{{ $biddingBookName }}"
                        class="btn btn-sm inline-flex items-center gap-2 border-black-900 bg-transparent text-black-900 hover:border-black-900 hover:bg-black-900 hover:text-beige-100"
                    >
                        <span>{{ $downloadCta }}</span>
                        <svg class="size-4 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M8 2.5v8M8 10.5L5 7.5M8 10.5L11 7.5M3 13.5h10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection
