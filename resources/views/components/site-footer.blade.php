@props([
    'showHero' => true,
    'background' => 'beige',
    'heroTitle' => null,
    'heroText' => null,
    'heroHighlight' => null,
    'heroQuestion' => null,
])

@php
    $navPrimary = [
        ['label' => __('site.nav.why'), 'href' => route('pages.why')],
        ['label' => __('site.footer.district_norte'), 'href' => route('pages.distrito', 'siglo-xxi')],
        ['label' => __('site.footer.district_centro'), 'href' => route('pages.distrito', 'cic')],
        ['label' => __('site.nav.plan_event'), 'href' => route('pages.plan')],
    ];

    $navSecondary = [
        ['label' => __('site.nav.about'), 'href' => route('pages.about')],
        ['label' => __('site.footer.supports'), 'href' => route('pages.apoyos')],
        ['label' => __('site.nav.events'), 'href' => route('pages.events')],
        ['label' => __('site.footer.specialists'), 'href' => route('pages.allies')],
    ];

    $navExternal = [
        [
            'label' => __('site.footer.fideture'),
            'href' => __('site.fideture_page.about_cta_url'),
            'external' => true,
        ],
        [
            'label' => __('site.footer.yucatan_tourism'),
            'href' => 'https://www.yucatan.travel/',
            'external' => true,
        ],
        [
            'label' => __('site.footer.cic'),
            'href' => __('site.distrito_cic.cta_url'),
            'external' => true,
        ],
        [
            'label' => __('site.footer.siglo_xxi'),
            'href' => __('site.distrito_siglo_xxi.cta_url'),
            'external' => true,
        ],
    ];

    $socials = site_settings()->socials();
    $mapsHref = 'https://maps.google.com/?q='.urlencode(site_settings()->address());

    $legal = [
        ['label' => __('site.footer.terms'), 'href' => route('legal.terms')],
        ['label' => __('site.footer.cookies'), 'href' => route('legal.cookies')],
        ['label' => __('site.footer.privacy'), 'href' => route('legal.privacy')],
    ];

    $footerBg = $background === 'yellow' ? 'bg-yellow-500' : 'bg-beige-500';
    $externalIcon = '<svg class="size-3.5 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M4 12L12 4M12 4H6.5M12 4V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';

    $resolvedHeroTitle = $heroTitle ?? __('site.footer.hero_title');
    $resolvedHeroText = $heroText ?? __('site.footer.hero_text');
@endphp

<footer {{ $attributes->class([$footerBg, 'text-black-900']) }}>
    <div class="mx-auto max-w-site px-6 lg:px-10">
        @if ($showHero)
            <section
                class="flex items-center justify-center py-16 lg:py-24"
                aria-labelledby="footer-hero-title"
            >
                <div class="flex w-full max-w-4xl flex-col items-center px-6 py-4 text-center text-black-900 lg:px-10">
                    <img
                        src="{{ asset('images/home/section6/iconosuperior.svg') }}"
                        alt=""
                        class="mb-6 h-auto w-[100px]"
                        width="100"
                        height="62"
                        aria-hidden="true"
                    >

                    <h2 id="footer-hero-title" class="max-w-prose text-s3 uppercase text-black-900 sm:text-s2">
                        {{ $resolvedHeroTitle }}
                    </h2>

                    <p class="mt-2 max-w-prose text-s3 font-book text-black-900">
                        {{ $resolvedHeroText }}
                    </p>

                    @if ($heroHighlight)
                        <p class="mt-4 text-s3 text-black-900">
                            {{ $heroHighlight }}
                        </p>
                    @endif

                    @if ($heroQuestion)
                        <p class="mt-4 text-s3 text-black-900">
                            {{ $heroQuestion }}
                        </p>
                    @endif

                    <div class="mt-8">
                        <x-button variant="primary" size="sm" href="{{ route('pages.plan') }}">
                            {{ __('site.common.plan_event') }}
                        </x-button>
                    </div>
                </div>
            </section>
        @endif

        <section
            @class([
                'border-t border-black-900 pb-8 pt-14 lg:pt-16',
                'mt-10 lg:mt-14' => ! $showHero,
            ])
            aria-label="{{ __('site.footer.aria_label') }}"
        >
            {{-- Móvil --}}
            <div class="flex flex-col items-center gap-10 text-center lg:hidden">
                <a href="{{ route('home') }}" class="shrink-0" aria-label="{{ config('app.name') }}">
                    <img
                        src="{{ asset('images/footer/yucatan-circle.svg') }}"
                        alt="{{ config('app.name') }}"
                        class="h-[120px] w-auto"
                        width="117"
                        height="120"
                    >
                </a>

                <nav class="flex flex-col items-center gap-4" aria-label="{{ __('site.footer.aria_label') }}">
                    @foreach (array_merge($navPrimary, $navSecondary, $navExternal) as $item)
                        <a
                            href="{{ $item['href'] }}"
                            class="inline-flex items-center gap-1 text-b2 font-bold text-black-900 transition-opacity hover:opacity-70"
                            @if (! empty($item['external']) && $item['href'] !== '#') target="_blank" rel="noopener noreferrer" @endif
                        >
                            <span>{{ $item['label'] }}</span>
                            @if (! empty($item['external']))
                                {!! $externalIcon !!}
                            @endif
                        </a>
                    @endforeach
                </nav>

                <div class="space-y-2">
                    <p class="text-b2 font-bold">{{ __('site.footer.contact') }}</p>
                    <a href="{{ site_settings()->emailHref() }}" class="block text-b2 font-book transition-opacity hover:opacity-70">
                        {{ site_settings()->email() }}
                    </a>
                    <a href="{{ site_settings()->phoneHref() }}" class="block text-b2 font-book transition-opacity hover:opacity-70">
                        {{ site_settings()->phone() }}
                    </a>
                    <a
                        href="{{ $mapsHref }}"
                        class="block text-b2 font-book transition-opacity hover:opacity-70"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        {{ __('site.footer.location') }}
                    </a>
                </div>

                <div>
                    <p class="mb-3 text-b2 font-bold">{{ __('site.footer.socials') }}</p>
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        @foreach ($socials as $social)
                            <a
                                href="{{ $social['href'] }}"
                                class="inline-flex size-[34px] items-center justify-center transition-opacity hover:opacity-70"
                                aria-label="{{ $social['label'] }}"
                                @if ($social['href'] !== '#') target="_blank" rel="noopener noreferrer" @endif
                            >
                                <img
                                    src="{{ asset($social['icon']) }}"
                                    alt=""
                                    class="size-[34px]"
                                    width="34"
                                    height="34"
                                    aria-hidden="true"
                                >
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="flex w-[170px] flex-col items-center gap-8">
                    <img
                        src="{{ asset('images/footer/visit-yucatan.svg') }}"
                        alt="{{ config('app.name') }}"
                        class="h-auto w-full"
                        width="170"
                        height="48"
                    >
                    <img
                        src="{{ asset('images/footer/Fideture.svg') }}"
                        alt="Fideture"
                        class="h-auto w-full"
                        width="170"
                        height="24"
                    >
                </div>
            </div>

            {{-- Desktop: logos fijos a los lados; columnas internas con gap uniforme --}}
            <div class="hidden lg:flex lg:items-start lg:justify-between lg:gap-x-8 xl:gap-x-10">
                <a href="{{ route('home') }}" class="shrink-0" aria-label="{{ config('app.name') }}">
                    <img
                        src="{{ asset('images/footer/yucatan-circle.svg') }}"
                        alt="{{ config('app.name') }}"
                        class="h-[120px] w-auto"
                        width="117"
                        height="120"
                    >
                </a>

                <div class="flex min-w-0 flex-1 items-start justify-between gap-x-6 px-4 xl:gap-x-8 xl:px-8">
                    <nav class="shrink-0 space-y-3" aria-label="{{ __('site.footer.aria_label') }}">
                        @foreach ($navPrimary as $item)
                            <a
                                href="{{ $item['href'] }}"
                                class="block text-b2 font-bold text-black-900 transition-opacity hover:opacity-70"
                            >
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </nav>

                    <nav class="shrink-0 space-y-3" aria-label="{{ __('site.footer.aria_label') }}">
                        @foreach ($navSecondary as $item)
                            <a
                                href="{{ $item['href'] }}"
                                class="block text-b2 font-bold text-black-900 transition-opacity hover:opacity-70"
                            >
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </nav>

                    <nav class="shrink-0 space-y-3" aria-label="{{ __('site.footer.aria_label') }}">
                        @foreach ($navExternal as $item)
                            <a
                                href="{{ $item['href'] }}"
                                class="flex w-fit items-center gap-1 text-b2 font-bold text-black-900 transition-opacity hover:opacity-70"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <span>{{ $item['label'] }}</span>
                                {!! $externalIcon !!}
                            </a>
                        @endforeach
                    </nav>

                    <div class="shrink-0 space-y-2">
                        <p class="text-b2 font-bold">{{ __('site.footer.contact') }}</p>
                        <a href="{{ site_settings()->emailHref() }}" class="block text-b2 font-book transition-opacity hover:opacity-70">
                            {{ site_settings()->email() }}
                        </a>
                        <a href="{{ site_settings()->phoneHref() }}" class="block text-b2 font-book transition-opacity hover:opacity-70">
                            {{ site_settings()->phone() }}
                        </a>
                        <a
                            href="{{ $mapsHref }}"
                            class="block text-b2 font-book transition-opacity hover:opacity-70"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            {{ __('site.footer.location') }}
                        </a>
                    </div>

                    <div class="shrink-0">
                        <p class="mb-3 text-b2 font-bold">{{ __('site.footer.socials') }}</p>
                        <div class="grid w-fit grid-cols-3 gap-3">
                            @foreach ($socials as $social)
                                <a
                                    href="{{ $social['href'] }}"
                                    class="inline-flex size-[34px] items-center justify-center transition-opacity hover:opacity-70"
                                    aria-label="{{ $social['label'] }}"
                                    @if ($social['href'] !== '#') target="_blank" rel="noopener noreferrer" @endif
                                >
                                    <img
                                        src="{{ asset($social['icon']) }}"
                                        alt=""
                                        class="size-[34px]"
                                        width="34"
                                        height="34"
                                        aria-hidden="true"
                                    >
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex w-[170px] shrink-0 flex-col items-center gap-8">
                    <img
                        src="{{ asset('images/footer/visit-yucatan.svg') }}"
                        alt="{{ config('app.name') }}"
                        class="h-auto w-full"
                        width="170"
                        height="48"
                    >
                    <img
                        src="{{ asset('images/footer/Fideture.svg') }}"
                        alt="Fideture"
                        class="h-auto w-full"
                        width="170"
                        height="24"
                    >
                </div>
            </div>

            <div class="mt-12 border-t border-black-900 pt-6">
                <ul class="flex flex-wrap items-center justify-center gap-x-3 gap-y-2 text-b3 font-book text-black-900">
                    @foreach ($legal as $index => $item)
                        <li class="flex items-center gap-3">
                            @if ($index > 0)
                                <span class="text-black-500" aria-hidden="true">|</span>
                            @endif
                            <a href="{{ $item['href'] }}" class="transition-opacity hover:opacity-70">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    </div>
</footer>
