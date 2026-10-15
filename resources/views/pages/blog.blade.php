@extends('layouts.site')

@section('title', __('site.nav.blog').' — '.config('app.name'))
@section('body_class', 'bg-beige-500')

@section('content')
    @php
        use App\Models\BlogPost;

        $blogCms = cms_page('blog');
        $heroTitle = $blogCms->text('hero.title', 'site.blog_page.title');
        $heroSubtitle = $blogCms->text('hero.subtitle', 'site.blog_page.subtitle');
        $heroImage = $blogCms->image('hero.image', 'images/svg/doblesilla.svg');

        $posts = BlogPost::query()
            ->published()
            ->ordered()
            ->get()
            ->map(fn (BlogPost $post) => $post->toCardItem())
            ->values()
            ->all();

        $categories = collect($posts)
            ->pluck('category')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();
    @endphp

    <main
        class="bg-beige-500 text-black-900"
        x-data="{
            category: '',
            filter2: '',
            filter3: '',
            filtersOpen: false,
            perPage: 8,
            page: 1,
            gridReady: true,
            transitioning: false,
            items: {{ Js::from($posts) }},
            get filtered() {
                return this.items.filter((item) => {
                    if (this.category && item.category !== this.category) return false;
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
        <section class="bg-beige-500 pt-14 lg:pt-20" aria-labelledby="blog-title">
            <div class="mx-auto flex w-full max-w-site flex-col px-6 lg:px-10">
                <div class="mx-auto flex max-w-3xl flex-col items-center text-center">
                    <h1 id="blog-title" class="text-h4 text-black-900 lg:text-h3">
                        {{ $heroTitle }}
                    </h1>

                    <p class="mt-4 max-w-2xl text-s3 text-black-900 lg:mt-5 lg:text-s2">
                        {{ $heroSubtitle }}
                    </p>

                    <img
                        src="{{ cms_asset($heroImage) }}"
                        alt=""
                        class="mt-8 h-[52px] w-auto lg:mt-10 lg:h-[60px]"
                        height="60"
                        aria-hidden="true"
                    >
                </div>

                <div class="mt-12 border-t-2 border-black-900 pt-5 lg:mt-16 lg:pt-6">
                    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:gap-4">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-b2 font-bold text-black-900">{{ __('site.blog_page.explore_by') }}</p>

                            <button
                                type="button"
                                class="inline-flex size-10 items-center justify-center text-black-900 transition lg:hidden"
                                :class="filtersOpen ? 'opacity-100' : 'opacity-70'"
                                aria-label="{{ __('site.blog_page.filter_placeholder') }}"
                                :aria-expanded="filtersOpen.toString()"
                                @click="filtersOpen = !filtersOpen"
                            >
                                <svg class="size-5" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                    <path d="M3 5h14M5 10h10M8 15h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>

                        <div
                            class="flex-col gap-3 lg:flex-row lg:flex-wrap lg:items-center"
                            :class="filtersOpen ? 'flex' : 'hidden lg:flex'"
                        >
                            <label class="sr-only" for="blog-category">{{ __('site.blog_page.filter_category') }}</label>
                            <select
                                id="blog-category"
                                class="select-filter w-full lg:w-auto"
                                x-model="category"
                                x-on:change="resetPage()"
                            >
                                <option value="">{{ __('site.blog_page.filter_category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>

                            <label class="sr-only" for="blog-filter-2">{{ __('site.blog_page.filter_placeholder') }}</label>
                            <select
                                id="blog-filter-2"
                                class="select-filter w-full lg:w-auto"
                                x-model="filter2"
                                x-on:change="resetPage()"
                            >
                                <option value="">{{ __('site.blog_page.filter_placeholder') }}</option>
                                <option value="a">{{ __('site.blog_page.filter_option_a') }}</option>
                                <option value="b">{{ __('site.blog_page.filter_option_b') }}</option>
                            </select>

                            <label class="sr-only" for="blog-filter-3">{{ __('site.blog_page.filter_placeholder') }}</label>
                            <select
                                id="blog-filter-3"
                                class="select-filter w-full lg:w-auto"
                                x-model="filter3"
                                x-on:change="resetPage()"
                            >
                                <option value="">{{ __('site.blog_page.filter_placeholder') }}</option>
                                <option value="a">{{ __('site.blog_page.filter_option_a') }}</option>
                                <option value="b">{{ __('site.blog_page.filter_option_b') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-beige-500 py-8 lg:py-12" aria-label="{{ __('site.nav.blog') }}">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <ul
                    class="grid grid-cols-1 gap-5 transition duration-200 ease-out sm:grid-cols-2 lg:grid-cols-4 lg:gap-6"
                    :class="gridReady ? 'translate-y-0 opacity-100' : 'translate-y-2 opacity-0'"
                >
                    <template x-for="item in pageItems" :key="item.id">
                        <li>
                            <a
                                :href="item.href"
                                class="group flex h-full flex-col overflow-hidden rounded-2xl focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black-900"
                            >
                                <div class="aspect-[4/3] overflow-hidden bg-beige-100">
                                    <img
                                        :src="item.image"
                                        :alt="item.title"
                                        class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-[1.03]"
                                    >
                                </div>
                                <div class="flex min-h-[88px] flex-1 items-start gap-3 bg-green-300 px-4 py-4">
                                    <p
                                        class="line-clamp-3 flex-1 text-b3 font-bold text-black-900"
                                        x-text="item.title"
                                    ></p>
                                    <span
                                        class="mt-0.5 inline-flex size-8 shrink-0 items-center justify-center rounded-full bg-green-100 text-black-900 transition group-hover:bg-black-900 group-hover:text-beige-100"
                                        aria-hidden="true"
                                    >
                                        <svg class="size-3.5" viewBox="0 0 16 16" fill="none">
                                            <path d="M4 12L12 4M12 4H6.5M12 4V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </div>
                            </a>
                        </li>
                    </template>
                </ul>

                <p
                    class="mt-10 text-center text-b2 font-book text-black-700"
                    x-show="total === 0"
                    x-cloak
                >
                    {{ __('site.blog_page.empty') }}
                </p>

                <div class="mt-10 flex flex-wrap items-center justify-end gap-4" x-show="total > 0" x-cloak>
                    <div class="flex items-center gap-3">
                        <p class="text-b2 font-bold text-black-900">{{ __('site.blog_page.per_page') }}</p>
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
                            {{ __('site.blog_page.of') }}
                            <span x-text="total"></span>
                        </p>

                        <button
                            type="button"
                            class="inline-flex size-9 items-center justify-center text-black-900 transition disabled:text-black-300"
                            aria-label="{{ __('site.blog_page.prev_page') }}"
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
                            aria-label="{{ __('site.blog_page.next_page') }}"
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
