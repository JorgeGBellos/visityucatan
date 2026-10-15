@extends('layouts.site')

@section('title', __('site.nav.events').' — '.config('app.name'))
@section('body_class', 'bg-beige-500')

@section('content')
    @php
        use App\Models\Event;

        $eventsCms = cms_page('events');
        $bannerTitle = $eventsCms->text('banner.title', 'site.events_page.banner_title');
        $introText = $eventsCms->text('intro', 'site.events_page.intro');
        $bannerVideo = 'videos/eventos.mov';

        $events = Event::query()
            ->published()
            ->ordered()
            ->get()
            ->map(fn (Event $event) => $event->toCardItem())
            ->values()
            ->all();

        $categories = collect(__('site.events_page.categories'))
            ->map(fn (string $label, string $key) => [
                'key' => $key,
                'label' => $label,
            ])
            ->values()
            ->all();
    @endphp

    <main
        class="bg-beige-500 text-black-900"
        x-data="{
            category: '',
            sort: 'soonest',
            filterOpen: false,
            perPage: 8,
            page: 1,
            gridReady: true,
            transitioning: false,
            items: {{ Js::from($events) }},
            categories: {{ Js::from($categories) }},
            get filtered() {
                let list = this.items.filter((item) => !this.category || item.categoryKey === this.category);
                if (this.sort === 'az') {
                    list = [...list].sort((a, b) => a.title.localeCompare(b.title));
                } else if (this.sort === 'za') {
                    list = [...list].sort((a, b) => b.title.localeCompare(a.title));
                } else {
                    list = [...list].sort((a, b) => String(a.startsAt || '').localeCompare(String(b.startsAt || '')));
                }
                return list;
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
            get activeCategoryLabel() {
                if (!this.category) return '';
                const match = this.categories.find((item) => item.key === this.category);
                return match ? match.label : '';
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
                this.animateChange(() => {
                    this.category = value;
                    this.filterOpen = false;
                    this.page = 1;
                });
            },
            clearCategory() {
                this.setCategory('');
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
        x-on:keydown.escape.window="filterOpen = false"
    >
        <section
            class="relative flex h-[calc(100svh-90px)] min-h-[calc(100svh-90px)] flex-col overflow-hidden bg-black-900"
            aria-labelledby="events-banner-title"
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
                    id="events-banner-title"
                    class="m-0 max-w-4xl whitespace-pre-line text-h4 uppercase text-beige-100 lg:text-h3"
                >{{ trim($bannerTitle) }}</h1>
            </div>
        </section>

        <section class="bg-beige-500 pt-14 lg:pt-20" aria-labelledby="events-intro-title">
            <div class="mx-auto flex w-full max-w-site flex-col px-6 lg:px-10">
                <div class="mx-auto flex max-w-3xl flex-col items-center text-center">
                    <img
                        src="{{ asset('images/svg/casita.svg') }}"
                        alt=""
                        class="h-[52px] w-auto lg:h-[60px]"
                        height="60"
                        aria-hidden="true"
                    >

                    <p id="events-intro-title" class="mt-8 text-s1 text-black-900 lg:mt-10 lg:text-h4">
                        {{ $introText }}
                    </p>
                </div>

                <div class="mt-12 border-t-2 border-black-900 pt-5 lg:mt-16 lg:pt-6">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="space-y-3">
                            <div class="relative" x-on:click.outside="filterOpen = false">
                                <button
                                    type="button"
                                    class="inline-flex items-center gap-2 text-btn3 font-book text-black-900 transition hover:opacity-70"
                                    :aria-expanded="filterOpen.toString()"
                                    x-on:click="filterOpen = !filterOpen"
                                >
                                    <span>{{ __('site.events_page.filter_by') }}</span>
                                    <svg class="size-3.5 transition" :class="filterOpen ? 'rotate-180' : ''" viewBox="0 0 12 8" fill="none" aria-hidden="true">
                                        <path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>

                                <div
                                    class="absolute left-0 top-full z-20 mt-3 min-w-[240px] rounded-[20px] bg-beige-100 px-5 py-4 shadow-[0_8px_24px_rgba(20,17,18,0.12)]"
                                    x-show="filterOpen"
                                    x-cloak
                                    x-transition
                                    role="listbox"
                                    aria-label="{{ __('site.events_page.filter_by') }}"
                                >
                                    <p class="mb-3 text-b3 font-book text-black-700">{{ __('site.events_page.filter_by') }}</p>
                                    <ul class="space-y-2.5">
                                        <li>
                                            <button
                                                type="button"
                                                class="flex w-full items-center gap-2.5 text-left text-b3 font-bold text-black-900 transition hover:opacity-70"
                                                role="option"
                                                :aria-selected="(category === '').toString()"
                                                x-on:click="setCategory('')"
                                            >
                                                <span class="size-1.5 shrink-0 rounded-full bg-black-900" aria-hidden="true"></span>
                                                <span>{{ __('site.events_page.filter_all') }}</span>
                                            </button>
                                        </li>
                                        <template x-for="option in categories" :key="option.key">
                                            <li>
                                                <button
                                                    type="button"
                                                    class="flex w-full items-center gap-2.5 text-left text-b3 font-bold text-black-900 transition hover:opacity-70"
                                                    role="option"
                                                    :aria-selected="(category === option.key).toString()"
                                                    x-on:click="setCategory(option.key)"
                                                >
                                                    <span class="size-1.5 shrink-0 rounded-full bg-black-900" aria-hidden="true"></span>
                                                    <span x-text="option.label"></span>
                                                </button>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>

                            <button
                                type="button"
                                class="inline-flex items-center gap-2 rounded-full bg-orange-100 px-5 py-2.5 text-btn3 font-bold uppercase tracking-[0.04em] text-black-900 transition hover:opacity-80"
                                x-show="category"
                                x-cloak
                                x-on:click="clearCategory()"
                            >
                                <span aria-hidden="true">×</span>
                                <span x-text="activeCategoryLabel"></span>
                            </button>
                        </div>

                        <div class="flex items-center gap-3">
                            <p class="text-btn3 font-bold uppercase tracking-[0.04em] text-black-900">
                                {{ __('site.events_page.sort_by') }}
                            </p>
                            <label class="sr-only" for="events-sort">{{ __('site.events_page.sort_by') }}</label>
                            <select
                                id="events-sort"
                                class="select-filter"
                                x-model="sort"
                                x-on:change="resetPage()"
                            >
                                <option value="soonest">{{ __('site.events_page.sort_soonest') }}</option>
                                <option value="az">{{ __('site.events_page.sort_az') }}</option>
                                <option value="za">{{ __('site.events_page.sort_za') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-beige-500 py-8 lg:py-12" aria-label="{{ __('site.nav.events') }}">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <ul
                    class="grid grid-cols-1 gap-5 transition duration-200 ease-out sm:grid-cols-2 lg:grid-cols-4 lg:gap-6"
                    :class="gridReady ? 'translate-y-0 opacity-100' : 'translate-y-2 opacity-0'"
                >
                    <template x-for="item in pageItems" :key="item.id">
                        <li class="overflow-hidden rounded-2xl bg-yellow-100">
                            <div class="aspect-[4/3] overflow-hidden bg-beige-100">
                                <img
                                    :src="item.image"
                                    :alt="item.title"
                                    class="h-full w-full object-cover"
                                >
                            </div>
                            <div class="flex flex-col gap-2 px-4 py-4">
                                <p class="text-btn3 font-book uppercase tracking-[0.04em] text-black-900" x-text="item.category"></p>
                                <h2 class="text-b2 font-bold text-black-900" x-text="item.title"></h2>
                                <p class="flex items-start gap-2 text-b3 font-book text-black-900">
                                    <svg class="mt-0.5 size-4 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                        <rect x="2" y="3" width="12" height="11" rx="1.5" stroke="currentColor" stroke-width="1.25"/>
                                        <path d="M2 6.5h12M5.5 1.5v3M10.5 1.5v3" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"/>
                                    </svg>
                                    <span x-text="item.date"></span>
                                </p>
                                <p class="flex items-start gap-2 text-b3 font-book text-black-900">
                                    <svg class="mt-0.5 size-4 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                        <path d="M8 8.75a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" stroke="currentColor" stroke-width="1.25"/>
                                        <path d="M12.5 6.75c0 3.25-4.5 7-4.5 7s-4.5-3.75-4.5-7a4.5 4.5 0 1 1 9 0Z" stroke="currentColor" stroke-width="1.25" stroke-linejoin="round"/>
                                    </svg>
                                    <span x-text="item.location"></span>
                                </p>
                            </div>
                        </li>
                    </template>
                </ul>

                <p
                    class="mt-10 text-center text-b2 font-book text-black-700"
                    x-show="total === 0"
                    x-cloak
                >
                    {{ __('site.events_page.empty') }}
                </p>

                <div class="mt-10 flex flex-wrap items-center justify-end gap-4" x-show="total > 0" x-cloak>
                    <div class="flex items-center gap-3">
                        <p class="text-b2 font-bold text-black-900">{{ __('site.events_page.per_page') }}</p>
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
                            {{ __('site.events_page.of') }}
                            <span x-text="total"></span>
                        </p>

                        <button
                            type="button"
                            class="inline-flex size-9 items-center justify-center text-black-900 transition disabled:text-black-300"
                            aria-label="{{ __('site.events_page.prev_page') }}"
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
                            aria-label="{{ __('site.events_page.next_page') }}"
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
