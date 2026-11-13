@php
    $organizeNav = [
        ['label' => __('site.nav.destination_supports'), 'href' => route('pages.apoyos')],
        ['label' => __('site.nav.specialists'), 'href' => route('pages.allies')],
        ['label' => __('site.nav.events'), 'href' => route('pages.events')],
    ];

    $meetNav = [
        ['label' => __('site.nav.about'), 'href' => route('pages.about')],
        ['label' => __('site.nav.fideture'), 'href' => route('pages.fideture')],
        ['label' => __('site.nav.blog'), 'href' => route('pages.blog')],
    ];

    $tourismNav = [
        'label' => __('site.nav.yucatan_tourism'),
        'href' => 'https://www.yucatan.travel/',
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
        openMenu: null,
        pendingLocale: '{{ $currentLocale }}',
        localeHrefs: {{ Js::from(collect($locales)->mapWithKeys(fn ($l) => [$l['code'] => $l['href']])) }},
        close() {
            this.menuOpen = false;
            this.langOpen = false;
            this.langDropdown = false;
            this.openMenu = null;
        },
        openLangSheet() {
            this.langDropdown = false;
            this.openMenu = null;
            this.pendingLocale = '{{ $currentLocale }}';
            this.langOpen = true;
        },
        toggleLangDropdown() {
            this.langOpen = false;
            this.openMenu = null;
            this.langDropdown = !this.langDropdown;
        },
        toggleNav(name) {
            this.langDropdown = false;
            this.langOpen = false;
            this.openMenu = this.openMenu === name ? null : name;
        },
        applyLocale() {
            const href = this.localeHrefs[this.pendingLocale];
            if (href) window.location.href = href;
        }
    }"
    x-init="
        const mq = window.matchMedia('(min-width: 1280px)');
        const onChange = () => {
            if (mq.matches) {
                menuOpen = false;
                langOpen = false;
            } else {
                langDropdown = false;
                openMenu = null;
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
        {{-- Móvil: idioma izq · logo centro · menú der --}}
        <div class="mx-auto grid h-full max-w-site grid-cols-[2.5rem_1fr_2.5rem] items-center px-6 xl:hidden">
            <button
                type="button"
                class="inline-flex size-10 items-center justify-center justify-self-start text-black-900 transition-opacity hover:opacity-70"
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

            <a
                href="{{ route('home') }}"
                class="justify-self-center"
                aria-label="{{ config('app.name') }}"
                @click="close()"
            >
                <img
                    src="{{ asset('images/logotipos/visit-vertical.svg') }}"
                    alt="{{ config('app.name') }}"
                    class="h-12 w-auto"
                    width="160"
                    height="48"
                >
            </a>

            <button
                type="button"
                class="inline-flex size-10 items-center justify-center justify-self-end text-black-900 transition-opacity hover:opacity-70"
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

        {{-- Desktop: logo · navegación · idioma + contacto --}}
        <div class="mx-auto hidden h-full max-w-site items-center gap-4 px-6 xl:flex 2xl:gap-6 2xl:px-10">
            <a href="{{ route('home') }}" class="shrink-0" aria-label="{{ config('app.name') }}" @click="close()">
                <img
                    src="{{ asset('images/logotipos/horizontal.svg') }}"
                    alt="{{ config('app.name') }}"
                    class="h-5 w-auto"
                    width="245"
                    height="24"
                >
            </a>

            <nav class="flex h-full min-w-0 flex-1 items-center justify-center gap-3 2xl:gap-6" aria-label="{{ __('site.nav.primary') }}">
                <a href="{{ route('pages.why') }}" class="whitespace-nowrap text-btn3 font-book uppercase tracking-[0.04em] text-black-900 transition-colors hover:text-green-700" @click="close()">
                    {{ __('site.nav.why') }}
                </a>
                <a href="{{ route('pages.districts') }}" class="whitespace-nowrap text-btn3 font-book uppercase tracking-[0.04em] text-black-900 transition-colors hover:text-green-700" @click="close()">
                    {{ __('site.nav.our_districts') }}
                </a>

                <div class="relative flex h-full items-center" @click.outside="if (openMenu === 'organize') openMenu = null">
                    <button
                        type="button"
                        class="inline-flex items-center gap-1.5 whitespace-nowrap text-btn3 font-book uppercase tracking-[0.04em] text-black-900 transition-colors hover:text-green-700"
                        :class="openMenu === 'organize' && 'text-green-700'"
                        aria-haspopup="menu"
                        :aria-expanded="(openMenu === 'organize').toString()"
                        aria-controls="organize-dropdown"
                        @click="toggleNav('organize')"
                    >
                        <span>{{ __('site.nav.organize_event') }}</span>
                        <svg class="size-3 transition-transform" :class="openMenu === 'organize' && 'rotate-180'" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                            <path d="M2.5 4.5L6 8l3.5-3.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div
                        id="organize-dropdown"
                        x-show="openMenu === 'organize'"
                        x-cloak
                        x-transition.opacity.duration.150ms
                        class="absolute top-full left-0 z-40 min-w-max rounded-b-lg border-x-2 border-b-2 border-black-900 bg-beige-500 px-5 py-4"
                        role="menu"
                        aria-label="{{ __('site.nav.organize_event') }}"
                    >
                        @foreach ($organizeNav as $item)
                            <a href="{{ $item['href'] }}" class="block whitespace-nowrap py-2 text-btn3 font-book uppercase tracking-[0.04em] text-black-900 transition-colors hover:text-green-700" role="menuitem" @click="close()">
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="relative flex h-full items-center" @click.outside="if (openMenu === 'meet') openMenu = null">
                    <button
                        type="button"
                        class="inline-flex items-center gap-1.5 whitespace-nowrap text-btn3 font-book uppercase tracking-[0.04em] text-black-900 transition-colors hover:text-green-700"
                        :class="openMenu === 'meet' && 'text-green-700'"
                        aria-haspopup="menu"
                        :aria-expanded="(openMenu === 'meet').toString()"
                        aria-controls="meet-dropdown"
                        @click="toggleNav('meet')"
                    >
                        <span>{{ __('site.nav.meet_us') }}</span>
                        <svg class="size-3 transition-transform" :class="openMenu === 'meet' && 'rotate-180'" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                            <path d="M2.5 4.5L6 8l3.5-3.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div
                        id="meet-dropdown"
                        x-show="openMenu === 'meet'"
                        x-cloak
                        x-transition.opacity.duration.150ms
                        class="absolute top-full left-0 z-40 min-w-max rounded-b-lg border-x-2 border-b-2 border-black-900 bg-beige-500 px-5 py-4"
                        role="menu"
                        aria-label="{{ __('site.nav.meet_us') }}"
                    >
                        @foreach ($meetNav as $item)
                            <a href="{{ $item['href'] }}" class="block whitespace-nowrap py-2 text-btn3 font-book uppercase tracking-[0.04em] text-black-900 transition-colors hover:text-green-700" role="menuitem" @click="close()">
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ $tourismNav['href'] }}" class="inline-flex items-center gap-1.5 whitespace-nowrap text-btn3 font-book uppercase tracking-[0.04em] text-black-900 transition-colors hover:text-green-700" target="_blank" rel="noopener noreferrer">
                    <span>{{ $tourismNav['label'] }}</span>
                    <svg class="size-3.5 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M4 12L12 4M12 4H6.5M12 4V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </nav>

            <div class="flex h-full shrink-0 items-center justify-end gap-4">
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
                    {{ __('site.nav.contact_us') }}
                </x-button>
            </div>
        </div>
    </div>

    {{-- Overlay + menú --}}
    <div
        x-show="menuOpen"
        x-cloak
        class="fixed inset-0 top-[90px] z-40 xl:hidden"
        role="dialog"
        aria-modal="true"
        aria-label="{{ __('site.nav.primary') }}"
    >
        <div
            id="site-nav-menu"
            x-show="menuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="-translate-y-2 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="-translate-y-2 opacity-0"
            class="relative z-10 flex h-[calc(100svh-90px)] w-full flex-col bg-beige-500"
            @click.stop
        >
            <nav
                class="flex flex-1 flex-col items-center justify-center overflow-y-auto px-6 py-10"
                aria-label="{{ __('site.nav.primary') }}"
            >
                <ul class="flex flex-col items-center gap-6 text-center">
                    <li>
                        <a href="{{ route('pages.why') }}" class="text-s2 text-black-900 transition-opacity hover:opacity-70" @click="close()">
                            {{ __('site.nav.mobile_why') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.districts') }}" class="text-s2 text-black-900 transition-opacity hover:opacity-70" @click="close()">
                            {{ __('site.nav.districts') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.events') }}" class="text-s2 text-black-900 transition-opacity hover:opacity-70" @click="close()">
                            {{ __('site.nav.events') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.allies') }}" class="text-s2 text-black-900 transition-opacity hover:opacity-70" @click="close()">
                            {{ __('site.nav.mobile_specialists') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.apoyos') }}" class="text-s2 text-black-900 transition-opacity hover:opacity-70" @click="close()">
                            {{ __('site.nav.mobile_supports') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.about') }}" class="text-s2 text-black-900 transition-opacity hover:opacity-70" @click="close()">
                            {{ __('site.nav.about') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.fideture') }}" class="text-s2 text-black-900 transition-opacity hover:opacity-70" @click="close()">
                            {{ __('site.nav.fideture') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ $tourismNav['href'] }}" class="inline-flex items-center gap-1.5 text-s2 text-black-900 transition-opacity hover:opacity-70" target="_blank" rel="noopener noreferrer">
                            <span>{{ $tourismNav['label'] }}</span>
                            <svg class="size-3.5 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                <path d="M4 12L12 4M12 4H6.5M12 4V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pages.blog') }}" class="text-s2 text-black-900 transition-opacity hover:opacity-70" @click="close()">
                            {{ __('site.nav.blog') }}
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    {{-- Selector de idioma móvil (bottom sheet) --}}
    <div
        x-show="langOpen"
        x-cloak
        class="fixed inset-0 z-[60] xl:hidden"
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
