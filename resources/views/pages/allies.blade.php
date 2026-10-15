@extends('layouts.site')

@section('title', __('site.nav.allies').' — '.config('app.name'))
@section('body_class', 'bg-beige-500')

@section('content')
    @php
        use App\Models\Ally;

        $alliesCms = cms_page('allies');

        $heroTitle = $alliesCms->text('hero.title', 'site.allies_page.title');
        $heroSubtitle = $alliesCms->text('hero.subtitle', 'site.allies_page.subtitle');
        $heroImage = $alliesCms->image('hero.image', 'images/svg/doblesilla.svg');

        $allyRecords = Ally::query()->published()->ordered()->get();

        $allyTypes = $allyRecords
            ->pluck('category')
            ->filter()
            ->unique()
            ->sort()
            ->mapWithKeys(fn (string $category) => [$category => $category])
            ->all();

        $allies = $allyRecords
            ->map(fn (Ally $ally) => $ally->toDirectoryItem())
            ->values()
            ->all();
    @endphp

    <main
        class="bg-beige-500 text-black-900"
        x-data="{
            view: 'cards',
            type: '',
            filter2: '',
            filter3: '',
            filtersOpen: false,
            perPage: 12,
            page: 1,
            gridReady: true,
            transitioning: false,
            items: {{ Js::from($allies) }},
            get filtered() {
                return this.items.filter((item) => !this.type || item.type === this.type);
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
        <section class="bg-beige-500 py-16 lg:py-24" aria-labelledby="allies-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="mx-auto max-w-3xl text-center text-black-900">
                    <h1 id="allies-title" class="text-h2">
                        {{ $heroTitle }}
                    </h1>

                    <p class="mt-3 text-s2 font-book text-black-900 lg:mt-4">
                        {{ $heroSubtitle }}
                    </p>

                    <img
                        src="{{ cms_asset($heroImage) }}"
                        alt=""
                        class="mx-auto mt-6 h-auto w-[70px] lg:mt-8 lg:w-[90px]"
                        width="90"
                        aria-hidden="true"
                    >
                </div>
            </div>
        </section>

        <section class="bg-beige-500 py-8 lg:py-16" aria-label="{{ __('site.nav.allies') }}">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between lg:gap-6">
                    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:gap-3">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-s3 lg:text-b2 lg:font-book">{{ __('site.allies_page.explore_by') }}</p>

                            <div class="flex items-center gap-1 lg:hidden">
                                <button
                                    type="button"
                                    class="inline-flex size-10 items-center justify-center text-black-900 transition"
                                    :class="filtersOpen ? 'opacity-100' : 'opacity-70'"
                                    aria-label="{{ __('site.allies_page.filter_placeholder') }}"
                                    :aria-expanded="filtersOpen.toString()"
                                    @click="filtersOpen = !filtersOpen"
                                >
                                    <svg class="size-5" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                        <path d="M3 5h14M5 10h10M8 15h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </button>

                                <button
                                    type="button"
                                    class="inline-flex size-10 items-center justify-center transition"
                                    :class="view === 'cards' ? 'text-black-900' : 'text-black-300'"
                                    aria-label="{{ __('site.allies_page.view_cards') }}"
                                    :aria-pressed="(view === 'cards').toString()"
                                    x-on:click="view = 'cards'"
                                >
                                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M2 2h7v7H2V2zm9 0h7v7h-7V2zM2 11h7v7H2v-7zm9 0h7v7h-7v-7z"/>
                                    </svg>
                                </button>
                                <button
                                    type="button"
                                    class="inline-flex size-10 items-center justify-center transition"
                                    :class="view === 'columns' ? 'text-black-900' : 'text-black-300'"
                                    aria-label="{{ __('site.allies_page.view_columns') }}"
                                    :aria-pressed="(view === 'columns').toString()"
                                    x-on:click="view = 'columns'"
                                >
                                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M2 6h16v2H2V6zm0 6h16v2H2v-2z"/>
                                    </svg>
                                </button>
                                <button
                                    type="button"
                                    class="inline-flex size-10 items-center justify-center transition"
                                    :class="view === 'list' ? 'text-black-900' : 'text-black-300'"
                                    aria-label="{{ __('site.allies_page.view_list') }}"
                                    :aria-pressed="(view === 'list').toString()"
                                    x-on:click="view = 'list'"
                                >
                                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M2 4h16v2H2V4zm0 5h16v2H2V9zm0 5h16v2H2v-2z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div
                            class="flex-col gap-3 lg:flex-row lg:flex-wrap lg:items-center"
                            :class="filtersOpen ? 'flex' : 'hidden lg:flex'"
                        >
                            <label class="sr-only" for="ally-type">{{ __('site.allies_page.filter_type') }}</label>
                            <select
                                id="ally-type"
                                class="select-filter w-full lg:w-auto"
                                x-model="type"
                                x-on:change="resetPage()"
                            >
                                <option value="">{{ __('site.allies_page.filter_type') }}</option>
                                @foreach ($allyTypes as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>

                            <label class="sr-only" for="ally-filter-2">{{ __('site.allies_page.filter_placeholder') }}</label>
                            <select
                                id="ally-filter-2"
                                class="select-filter w-full lg:w-auto"
                                x-model="filter2"
                                x-on:change="resetPage()"
                            >
                                <option value="">{{ __('site.allies_page.filter_placeholder') }}</option>
                                <option value="a">{{ __('site.allies_page.filter_option_a') }}</option>
                                <option value="b">{{ __('site.allies_page.filter_option_b') }}</option>
                            </select>

                            <label class="sr-only" for="ally-filter-3">{{ __('site.allies_page.filter_placeholder') }}</label>
                            <select
                                id="ally-filter-3"
                                class="select-filter w-full lg:w-auto"
                                x-model="filter3"
                                x-on:change="resetPage()"
                            >
                                <option value="">{{ __('site.allies_page.filter_placeholder') }}</option>
                                <option value="a">{{ __('site.allies_page.filter_option_a') }}</option>
                                <option value="b">{{ __('site.allies_page.filter_option_b') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="hidden items-center gap-1 lg:flex">
                        <button
                            type="button"
                            class="inline-flex size-10 items-center justify-center transition"
                            :class="view === 'cards' ? 'text-black-900' : 'text-black-300'"
                            aria-label="{{ __('site.allies_page.view_cards') }}"
                            :aria-pressed="(view === 'cards').toString()"
                            x-on:click="view = 'cards'"
                        >
                            <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M2 2h7v7H2V2zm9 0h7v7h-7V2zM2 11h7v7H2v-7zm9 0h7v7h-7v-7z"/>
                            </svg>
                        </button>
                        <button
                            type="button"
                            class="inline-flex size-10 items-center justify-center transition"
                            :class="view === 'columns' ? 'text-black-900' : 'text-black-300'"
                            aria-label="{{ __('site.allies_page.view_columns') }}"
                            :aria-pressed="(view === 'columns').toString()"
                            x-on:click="view = 'columns'"
                        >
                            <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M2 6h16v2H2V6zm0 6h16v2H2v-2z"/>
                            </svg>
                        </button>
                        <button
                            type="button"
                            class="inline-flex size-10 items-center justify-center transition"
                            :class="view === 'list' ? 'text-black-900' : 'text-black-300'"
                            aria-label="{{ __('site.allies_page.view_list') }}"
                            :aria-pressed="(view === 'list').toString()"
                            x-on:click="view = 'list'"
                        >
                            <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M2 4h16v2H2V4zm0 5h16v2H2v-2z"/>
                            </svg>
                        </button>
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
                        @include('partials.directory-item', ['visitLabel' => __('site.allies_page.visit_site')])
                    </template>
                </ul>

                <p
                    class="mt-10 text-center text-b2 font-book text-black-700"
                    x-show="total === 0"
                    x-cloak
                >
                    {{ __('site.allies_page.empty') }}
                </p>

                <div class="mt-10 flex flex-wrap items-center justify-end gap-4" x-show="total > 0" x-cloak>
                    <div class="flex items-center gap-3">
                        <p class="text-b2 font-bold text-black-900">{{ __('site.allies_page.per_page') }}</p>
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
                            {{ __('site.allies_page.of') }}
                            <span x-text="total"></span>
                        </p>

                        <button
                            type="button"
                            class="inline-flex size-9 items-center justify-center text-black-900 transition disabled:text-black-300"
                            aria-label="{{ __('site.allies_page.prev_page') }}"
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
                            aria-label="{{ __('site.allies_page.next_page') }}"
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
