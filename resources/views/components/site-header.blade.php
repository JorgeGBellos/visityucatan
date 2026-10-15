@php
    $mobileNav = [
        ['label' => __('site.nav.mobile_why'), 'href' => route('pages.why')],
        ['label' => __('site.nav.districts'), 'href' => route('pages.districts')],
        ['label' => __('site.nav.events'), 'href' => route('pages.events')],
        ['label' => __('site.nav.mobile_specialists'), 'href' => route('pages.allies')],
        ['label' => __('site.nav.mobile_supports'), 'href' => route('pages.apoyos')],
        ['label' => __('site.nav.about'), 'href' => route('pages.about')],
        ['label' => __('site.nav.fideture'), 'href' => route('pages.fideture')],
        [
            'label' => __('site.nav.yucatan_tourism'),
            'href' => 'https://www.yucatan.travel/',
            'external' => true,
        ],
        ['label' => __('site.nav.blog'), 'href' => route('pages.blog')],
    ];

    $exploreNav = [
        ['label' => __('site.nav.why'), 'href' => route('pages.why')],
        ['label' => __('site.nav.our_districts'), 'href' => route('pages.districts')],
        ['label' => __('site.nav.district_supports'), 'href' => route('pages.apoyos')],
    ];

    $discoverNav = [
        ['label' => __('site.nav.about'), 'href' => route('pages.about')],
        ['label' => __('site.nav.events'), 'href' => route('pages.events')],
        ['label' => __('site.nav.specialists'), 'href' => route('pages.allies')],
        ['label' => __('site.nav.fideture'), 'href' => route('pages.fideture')],
        ['label' => __('site.nav.blog'), 'href' => route('pages.blog')],
        [
            'label' => __('site.nav.yucatan_tourism'),
            'href' => 'https://www.yucatan.travel/',
            'external' => true,
        ],
    ];

    $locales = collect(config('app.available_locales', ['es', 'en']))
        ->map(fn (string $code) => [
            'code' => $code,
            'label' => __('site.locales.'.$code),
            'href' => route('locale.switch', $code),
            'active' => app()->getLocale() === $code,
        ])
        ->values()
        ->all();

    $currentLocale = app()->getLocale();
@endphp

<header
    class="fixed inset-x-0 top-0 z-50"
    x-data="{
        menuOpen: false,
        langOpen: false,
        langDropdown: false,
        pendingLocale: '{{ $currentLocale }}',
        localeHrefs: {{ Js::from(collect($locales)->mapWithKeys(fn ($l) => [$l['code'] => $l['href']])) }},
        close() {
            this.menuOpen = false;
            this.langOpen = false;
            this.langDropdown = false;
        },
        openLangSheet() {
            this.langDropdown = false;
            this.pendingLocale = '{{ $currentLocale }}';
            this.langOpen = true;
        },
        toggleLangDropdown() {
            this.langOpen = false;
            this.langDropdown = !this.langDropdown;
        },
        applyLocale() {
            const href = this.localeHrefs[this.pendingLocale];
            if (href) window.location.href = href;
        }
    }"
    x-init="
        const mq = window.matchMedia('(min-width: 768px)');
        const onChange = () => {
            if (mq.matches) {
                langOpen = false;
            } else {
                langDropdown = false;
            }
        };
        mq.addEventListener('change', onChange);
    "
    x-effect="document.body.classList.toggle('overflow-hidden', menuOpen || langOpen)"
    @keydown.escape.window="close()"
>
    <div
        class="relative z-50 h-[90px] border-b-2 border-black-900 bg-beige-500"
    >
        {{-- Móvil: logo izq · idioma + menú der --}}
        <div class="mx-auto flex h-full max-w-site items-center justify-between gap-4 px-6 md:hidden">
            <a href="{{ route('home') }}" aria-label="{{ config('app.name') }}" @click="close()">
                <img
                    src="{{ asset('images/logotipos/visit-vertical.svg') }}"
                    alt="{{ config('app.name') }}"
                    class="h-12 w-auto"
                    width="160"
                    height="48"
                >
            </a>

            <div class="flex items-center gap-4">
                <button
                    type="button"
                    class="inline-flex size-6 items-center justify-center text-black-900 transition-opacity hover:opacity-70"
                    aria-label="{{ __('site.nav.change_language') }}"
                    aria-haspopup="dialog"
                    :aria-expanded="langOpen.toString()"
                    aria-controls="language-sheet"
                    @click="langOpen ? (langOpen = false) : openLangSheet()"
                >
                    <img
                        src="{{ asset('images/svg/world.svg') }}"
                        alt=""
                        class="size-6"
                        width="24"
                        height="24"
                        aria-hidden="true"
                    >
                </button>

                <button
                    type="button"
                    class="inline-flex size-8 items-center justify-center text-black-900 transition-opacity hover:opacity-70"
                    :aria-label="menuOpen ? '{{ __('site.nav.close_menu') }}' : '{{ __('site.nav.open_menu') }}'"
                    :aria-expanded="menuOpen.toString()"
                    aria-controls="site-nav-menu"
                    @click="menuOpen = !menuOpen"
                >
                    <svg x-show="!menuOpen" class="size-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <svg x-show="menuOpen" x-cloak class="size-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Desktop: menú izq · logo centro · idioma + CTA der --}}
        <div class="mx-auto hidden h-full max-w-site grid-cols-[1fr_auto_1fr] items-center gap-4 px-6 md:grid lg:px-10">
            <div class="flex items-center justify-start">
                <button
                    type="button"
                    class="inline-flex size-8 items-center justify-center text-black-900 transition-opacity hover:opacity-70"
                    :aria-label="menuOpen ? '{{ __('site.nav.close_menu') }}' : '{{ __('site.nav.open_menu') }}'"
                    :aria-expanded="menuOpen.toString()"
                    aria-controls="site-nav-menu"
                    @click="menuOpen = !menuOpen"
                >
                    <svg x-show="!menuOpen" class="size-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <svg x-show="menuOpen" x-cloak class="size-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            <a href="{{ route('home') }}" class="justify-self-center" aria-label="{{ config('app.name') }}" @click="close()">
                <img
                    src="{{ asset('images/logotipos/horizontal.svg') }}"
                    alt="{{ config('app.name') }}"
                    class="h-6 w-auto"
                    width="245"
                    height="24"
                >
            </a>

            <div class="flex h-full items-center justify-end gap-4">
                <div
                    class="relative flex h-full items-center"
                    @click.outside="langDropdown = false"
                >
                    <button
                        type="button"
                        class="inline-flex size-6 items-center justify-center text-black-900 transition-opacity hover:opacity-70"
                        aria-label="{{ __('site.nav.change_language') }}"
                        aria-haspopup="menu"
                        :aria-expanded="langDropdown.toString()"
                        aria-controls="language-dropdown"
                        @click="toggleLangDropdown()"
                    >
                        <img
                            src="{{ asset('images/svg/world.svg') }}"
                            alt=""
                            class="size-6"
                            width="24"
                            height="24"
                            aria-hidden="true"
                        >
                    </button>

                    <div
                        id="language-dropdown"
                        x-show="langDropdown"
                        x-cloak
                        x-transition.opacity.duration.150ms
                        class="absolute top-[calc(100%+12px)] left-1/2 z-40 flex min-w-[11rem] -translate-x-1/2 flex-col gap-3 bg-transparent p-0"
                        role="menu"
                        aria-label="{{ __('site.nav.language') }}"
                    >
                        @foreach ($locales as $locale)
                            <x-button
                                variant="{{ $locale['active'] ? 'primary' : 'secondary' }}"
                                size="sm"
                                href="{{ $locale['href'] }}"
                                role="menuitem"
                                @class([
                                    'w-full justify-center',
                                    '!bg-beige-500 hover:!bg-black-900 hover:!text-beige-100' => ! $locale['active'],
                                ])
                                x-on:click="langDropdown = false"
                            >
                                {{ $locale['label'] }}
                            </x-button>
                        @endforeach
                    </div>
                </div>

                <x-button variant="primary" size="sm" href="{{ route('pages.plan') }}">
                    {{ __('site.nav.plan_event') }}
                </x-button>
            </div>
        </div>
    </div>

    {{-- Overlay + menú --}}
    <div
        x-show="menuOpen"
        x-cloak
        class="fixed inset-0 top-[90px] z-40"
        role="dialog"
        aria-modal="true"
        aria-label="{{ __('site.nav.primary') }}"
    >
        <button
            type="button"
            class="absolute inset-0 hidden bg-black-900/40 transition-opacity md:block"
            aria-label="{{ __('site.nav.close_menu') }}"
            @click="close()"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></button>

        <div
            id="site-nav-menu"
            x-show="menuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="-translate-y-2 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="-translate-y-2 opacity-0"
            class="relative z-10 w-full bg-beige-500 max-md:flex max-md:h-[calc(100svh-90px)] max-md:flex-col md:border-b-2 md:border-black-900"
            @click.stop
        >
            {{-- Menú móvil: lista centrada s2 --}}
            <nav
                class="flex flex-1 flex-col items-center justify-center px-6 py-10 md:hidden"
                aria-label="{{ __('site.nav.primary') }}"
            >
                <ul class="flex flex-col items-center gap-5 text-center">
                    @foreach ($mobileNav as $item)
                        <li>
                            <a
                                href="{{ $item['href'] }}"
                                class="inline-flex items-center gap-1.5 text-s2 text-black-900 transition-opacity hover:opacity-70"
                                @if (! empty($item['external']))
                                    target="_blank"
                                    rel="noopener noreferrer"
                                @endif
                                @click="close()"
                            >
                                <span>{{ $item['label'] }}</span>
                                @if (! empty($item['external']))
                                    <svg class="size-3.5 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                        <path d="M4 12L12 4M12 4H6.5M12 4V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            {{-- Menú desktop --}}
            <div class="mx-auto hidden max-w-site px-6 py-16 md:block lg:px-10 lg:py-20">
                <div class="grid grid-cols-1 gap-10 lg:grid-cols-12 lg:gap-x-6 lg:gap-y-0">
                    {{-- EXPLORA — cols 1–4 --}}
                    <div class="lg:col-span-4">
                        <p class="text-label font-bold uppercase text-black-900">
                            {{ __('site.nav.explore') }}
                        </p>

                        <nav class="mt-5" aria-label="{{ __('site.nav.explore') }}">
                            <ul class="divide-y divide-black-900 border-b border-black-900">
                                @foreach ($exploreNav as $item)
                                    <li>
                                        <a
                                            href="{{ $item['href'] }}"
                                            class="group flex items-center justify-between gap-4 py-4 text-h4 text-black-900 transition-opacity hover:opacity-70"
                                            @click="close()"
                                        >
                                            <span>{{ $item['label'] }}</span>
                                            <svg class="size-4 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                                <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>

                    {{-- DESCUBRE — cols 7–9 --}}
                    <div class="lg:col-span-3 lg:col-start-7">
                        <p class="text-label font-bold uppercase text-black-900">
                            {{ __('site.nav.discover') }}
                        </p>

                        <nav class="mt-5" aria-label="{{ __('site.nav.discover') }}">
                            <ul class="flex flex-col gap-3">
                                @foreach ($discoverNav as $item)
                                    <li>
                                        <a
                                            href="{{ $item['href'] }}"
                                            class="inline-flex items-center gap-1.5 text-b3 font-book uppercase tracking-[0.04em] text-black-900 transition-opacity hover:opacity-70"
                                            @if (! empty($item['external']))
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            @endif
                                            @click="close()"
                                        >
                                            <span>{{ $item['label'] }}</span>
                                            @if (! empty($item['external']))
                                                <svg class="size-3.5 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                                    <path d="M4 12L12 4M12 4H6.5M12 4V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>

                    {{-- CONTACTO — cols 11–12 --}}
                    <div class="flex flex-col lg:col-span-2 lg:col-start-11">
                        <p class="text-label font-bold uppercase text-black-900">
                            {{ __('site.nav.contact') }}
                        </p>

                        <div class="mt-5 space-y-2 text-b3 font-book text-black-900">
                            <p>
                                <a href="{{ site_settings()->emailHref() }}" class="transition-opacity hover:opacity-70">
                                    {{ site_settings()->email() }}
                                </a>
                            </p>
                            <p>
                                <a href="{{ site_settings()->phoneHref() }}" class="transition-opacity hover:opacity-70">
                                    {{ site_settings()->phone() }}
                                </a>
                            </p>
                            <p>
                                {{ site_settings()->address() }}
                            </p>
                        </div>

                        <img
                            src="{{ asset('images/home/section6/iconosuperior.svg') }}"
                            alt=""
                            class="mt-8 h-auto w-14 self-start"
                            width="56"
                            aria-hidden="true"
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Selector de idioma móvil (bottom sheet) --}}
    <div
        x-show="langOpen"
        x-cloak
        class="fixed inset-0 z-[60] md:hidden"
        role="dialog"
        aria-modal="true"
        aria-label="{{ __('site.nav.language') }}"
    >
        <button
            type="button"
            class="absolute inset-0 bg-black-900/40"
            aria-label="{{ __('site.nav.close_menu') }}"
            @click="langOpen = false"
        ></button>

        <div
            id="language-sheet"
            x-show="langOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="translate-y-full"
            x-transition:enter-end="translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="translate-y-0"
            x-transition:leave-end="translate-y-full"
            class="absolute inset-x-0 bottom-0 rounded-t-[28px] bg-green-500 px-6 pb-8 pt-10 text-beige-100"
            @click.stop
        >
            <div class="mx-auto flex w-full max-w-md flex-col gap-3">
                @foreach ($locales as $locale)
                    <button
                        type="button"
                        class="flex w-full items-center justify-between px-5 py-3 text-left text-btn3 font-book uppercase tracking-[0.04em] text-beige-100 transition"
                        :class="pendingLocale === '{{ $locale['code'] }}' ? 'rounded-full bg-green-700' : 'rounded-full'"
                        @click="pendingLocale = '{{ $locale['code'] }}'"
                        :aria-pressed="(pendingLocale === '{{ $locale['code'] }}').toString()"
                    >
                        <span>{{ $locale['label'] }}</span>
                        <span
                            x-show="pendingLocale === '{{ $locale['code'] }}'"
                            class="inline-flex size-6 shrink-0 items-center justify-center rounded-full bg-beige-100 text-green-700"
                            aria-hidden="true"
                        >
                            <svg class="size-3.5" viewBox="0 0 14 14" fill="none">
                                <path d="M2.5 7.2L5.4 10.1L11.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </button>
                @endforeach

                <button
                    type="button"
                    class="btn btn-primary mt-4 w-full justify-center"
                    @click="applyLocale()"
                >
                    <span>{{ __('site.nav.apply') }}</span>
                </button>
            </div>
        </div>
    </div>
</header>
