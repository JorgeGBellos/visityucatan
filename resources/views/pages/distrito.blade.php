@extends('layouts.site')

@section('title', $title.' — '.config('app.name'))
@section('body_class', 'bg-beige-500')

@section('content')
    <main
        class="bg-beige-500 text-black-900"
        x-data="{
            category: {{ Js::from(array_key_first($tabs) ?: 'hotels') }},
            view: 'cards',
            type: '',
            filter2: '',
            filter3: '',
            filtersOpen: false,
            perPage: 12,
            page: 1,
            gridReady: true,
            transitioning: false,
            items: {{ Js::from($spaces) }},
            get filtered() {
                return this.items.filter((item) => {
                    if (item.category !== this.category) return false;
                    if (this.type && item.type !== this.type) return false;
                    if (this.filter2 && item.filter2 !== this.filter2) return false;
                    if (this.filter3 && item.filter3 !== this.filter3) return false;
                    return true;
                });
            },
            get total() {
                return this.filtered.length;
            },
            get totalPages() {
                return Math.max(1, Math.ceil(this.total / this.perPage));
            },
            get pageItems() {
                const start = (this.page - 1) * this.perPage;
                return this.filtered.slice(start, start + this.perPage);
            },
            get rangeStart() {
                return this.total === 0 ? 0 : (this.page - 1) * this.perPage + 1;
            },
            get rangeEnd() {
                return Math.min(this.page * this.perPage, this.total);
            },
            async animateChange(update) {
                if (this.transitioning) return;
                this.transitioning = true;
                this.gridReady = false;
                await new Promise((resolve) => setTimeout(resolve, 160));
                update();
                await this.$nextTick();
                this.gridReady = true;
                await new Promise((resolve) => setTimeout(resolve, 220));
                this.transitioning = false;
            },
            setCategory(value) {
                if (this.category === value) return;
                this.animateChange(() => {
                    this.category = value;
                    this.type = '';
                    this.filter2 = '';
                    this.filter3 = '';
                    this.page = 1;
                });
            },
            resetPage() {
                this.animateChange(() => { this.page = 1; });
            },
            changePerPage(value) {
                this.animateChange(() => {
                    this.perPage = Number(value);
                    this.page = 1;
                });
            },
            prev() {
                if (this.page <= 1) return;
                this.animateChange(() => { this.page -= 1; });
            },
            next() {
                if (this.page >= this.totalPages) return;
                this.animateChange(() => { this.page += 1; });
            }
        }"
    >
        <section
            class="relative flex h-[calc(100svh-90px)] min-h-[calc(100svh-90px)] flex-col overflow-hidden bg-black-900"
            aria-labelledby="distrito-banner-title"
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

            <div class="relative z-10 mx-auto mt-auto flex w-full max-w-site flex-col items-center px-6 pb-12 pt-24 text-center lg:px-10 lg:pb-16">
                <h1
                    id="distrito-banner-title"
                    class="m-0 max-w-4xl whitespace-pre-line text-h4 uppercase text-beige-100 lg:text-h3"
                >{{ trim($bannerTitle) }}</h1>
            </div>
        </section>

        <section class="bg-beige-500 py-14 lg:py-20" aria-labelledby="distrito-intro-title">
            <div class="mx-auto flex w-full max-w-site flex-col px-6 lg:px-10">
                <div class="mx-auto flex max-w-3xl flex-col items-center text-center">
                    <img
                        src="{{ asset('images/svg/casita.svg') }}"
                        alt=""
                        class="h-[52px] w-auto lg:h-[60px]"
                        height="60"
                        aria-hidden="true"
                    >

                    <h2
                        id="distrito-intro-title"
                        class="mt-8 text-s1 text-black-900 lg:mt-10"
                    >
                        {{ $introHeadline }}
                    </h2>

                    <p class="mt-5 max-w-2xl text-b2 font-book text-black-900 lg:mt-6">
                        {{ $introTextBefore }}<strong class="font-bold">{{ $introTextBold }}</strong>{{ $introTextAfter }}
                    </p>

                    <a
                        href="{{ $ctaUrl }}"
                        class="btn btn-sm btn-primary mt-8 inline-flex items-center gap-2 lg:mt-10"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <span>{{ $cta }}</span>
                        <svg class="size-3.5 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M4 12L12 4M12 4H6.5M12 4V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>

                <div class="mt-14 border-y-2 border-black-900 lg:mt-20">
                    <div class="flex flex-col gap-4 py-4 lg:flex-row lg:items-center lg:justify-between lg:gap-6 lg:py-5">
                        <p class="shrink-0 text-btn3 font-bold uppercase tracking-[0.04em] text-black-900">
                            {{ __('site.distrito_directory.filter_by') }}
                        </p>

                        <nav
                            class="flex flex-wrap items-center justify-center gap-1 sm:gap-2"
                            aria-label="{{ $title }}"
                        >
                            @foreach ($tabs as $key => $label)
                                <button
                                    type="button"
                                    class="text-btn3 font-bold uppercase tracking-[0.04em] transition"
                                    :class="category === '{{ $key }}'
                                        ? 'rounded-full bg-beige-100 px-4 py-2 text-black-900'
                                        : 'px-4 py-2 text-black-900 hover:opacity-70'"
                                    x-on:click="setCategory('{{ $key }}')"
                                    :aria-pressed="(category === '{{ $key }}').toString()"
                                >
                                    {{ $label }}
                                </button>
                            @endforeach
                        </nav>

                        <div class="flex items-center justify-end gap-1 lg:shrink-0">
                            <button
                                type="button"
                                class="inline-flex size-9 items-center justify-center transition"
                                :class="view === 'cards' ? 'text-black-900' : 'text-black-300'"
                                aria-label="{{ __('site.distrito_directory.view_cards') }}"
                                :aria-pressed="(view === 'cards').toString()"
                                x-on:click="view = 'cards'"
                            >
                                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M2 2h7v7H2V2zm9 0h7v7h-7V2zM2 11h7v7H2v-7zm9 0h7v7h-7v-7z"/>
                                </svg>
                            </button>
                            <button
                                type="button"
                                class="inline-flex size-9 items-center justify-center transition"
                                :class="view === 'columns' ? 'text-black-900' : 'text-black-300'"
                                aria-label="{{ __('site.distrito_directory.view_columns') }}"
                                :aria-pressed="(view === 'columns').toString()"
                                x-on:click="view = 'columns'"
                            >
                                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M2 6h16v2H2V6zm0 6h16v2H2v-2z"/>
                                </svg>
                            </button>
                            <button
                                type="button"
                                class="inline-flex size-9 items-center justify-center transition"
                                :class="view === 'list' ? 'text-black-900' : 'text-black-300'"
                                aria-label="{{ __('site.distrito_directory.view_list') }}"
                                :aria-pressed="(view === 'list').toString()"
                                x-on:click="view = 'list'"
                            >
                                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M2 4h16v2H2V4zm0 5h16v2H2V9zm0 5h16v2H2v-2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <ul
                    class="mt-8 gap-6 transition duration-200 ease-out lg:mt-10"
                    :class="[
                        view === 'cards' ? 'grid grid-cols-1 lg:grid-cols-4' : (view === 'columns' ? 'grid grid-cols-1 lg:grid-cols-2' : 'grid grid-cols-1'),
                        gridReady ? 'translate-y-0 opacity-100' : 'translate-y-2 opacity-0'
                    ]"
                >
                    <template x-for="item in pageItems" :key="item.id">
                        @include('partials.directory-item', ['visitLabel' => __('site.distrito_directory.visit_site')])
                    </template>
                </ul>

                <p
                    class="mt-10 text-center text-b2 font-book text-black-700"
                    x-show="total === 0"
                    x-cloak
                >
                    {{ __('site.distrito_directory.empty') }}
                </p>

                <div class="mt-10 flex flex-wrap items-center justify-end gap-4" x-show="total > 0" x-cloak>
                    <div class="flex items-center gap-3">
                        <p class="text-b2 font-bold text-black-900">{{ __('site.distrito_directory.per_page') }}</p>
                        <select
                            class="select-filter-sm"
                            :value="perPage"
                            x-on:change="changePerPage($event.target.value)"
                        >
                            <option value="8">8</option>
                            <option value="12">12</option>
                            <option value="24">24</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-4">
                        <p class="text-b2 font-book text-black-500">
                            <span x-text="rangeStart"></span>
                            –
                            <span x-text="rangeEnd"></span>
                            {{ __('site.distrito_directory.of') }}
                            <span x-text="total"></span>
                        </p>

                        <button
                            type="button"
                            class="inline-flex size-9 items-center justify-center text-black-900 transition disabled:text-black-300"
                            aria-label="{{ __('site.distrito_directory.prev_page') }}"
                            x-on:click="prev()"
                            :disabled="page <= 1 || transitioning"
                        >
                            <svg class="size-4" viewBox="0 0 18 12" fill="none" aria-hidden="true">
                                <path d="M17 6H1M1 6L6.5 1M1 6L6.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button
                            type="button"
                            class="inline-flex size-9 items-center justify-center text-black-900 transition disabled:text-black-300"
                            aria-label="{{ __('site.distrito_directory.next_page') }}"
                            x-on:click="next()"
                            :disabled="page >= totalPages || transitioning"
                        >
                            <svg class="size-4" viewBox="0 0 18 12" fill="none" aria-hidden="true">
                                <path d="M1 6H17M17 6L11.5 1M17 6L11.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
