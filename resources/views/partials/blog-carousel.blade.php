@php
    use App\Models\BlogPost;

    $titleId = $titleId ?? 'blog-carousel-title';
    $title = $title ?? __('site.about_page.blog_carousel_title');
    $text = $text ?? __('site.about_page.blog_carousel_text');
    $text2 = $text2 ?? __('site.about_page.blog_carousel_text_2');
    $cta = $cta ?? __('site.about_page.blog_carousel_cta');
    $ctaHref = $ctaHref ?? route('pages.blog');
    $sectionClass = $sectionClass ?? 'py-16 lg:py-24';

    $posts = $posts ?? BlogPost::query()
        ->published()
        ->ordered()
        ->limit(8)
        ->get()
        ->map(fn (BlogPost $post) => $post->toCardItem())
        ->values()
        ->all();
@endphp

@if ($posts !== [])
    <section
        class="overflow-x-clip bg-beige-500 {{ $sectionClass }}"
        aria-labelledby="{{ $titleId }}"
        x-data="siteCarousel"
    >
        <div class="mx-auto max-w-site px-6 lg:px-10">
            <div class="grid grid-cols-1 items-stretch gap-8 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,2.1fr)] lg:gap-12">
                <div class="flex flex-col items-start justify-center text-left text-black-900">
                    <h2 id="{{ $titleId }}" class="text-s2 lg:text-s1">
                        {{ $title }}
                    </h2>

                    <p class="mt-3 max-w-md text-b2 font-book text-black-900">
                        {{ $text }}
                    </p>

                    <p class="mt-3 max-w-md text-b2 font-book text-black-900">
                        {{ $text2 }}
                    </p>

                    <div class="mt-6">
                        <x-button variant="tertiary" class="border-black-900" href="{{ $ctaHref }}">
                            {{ $cta }}
                        </x-button>
                    </div>

                    <div class="mt-8 flex items-center gap-3 lg:mt-10">
                        <button
                            type="button"
                            class="inline-flex size-11 items-center justify-center rounded-full bg-beige-100 text-black-900 transition hover:bg-black-900 hover:text-beige-100"
                            aria-label="{{ __('site.about_page.blog_carousel_prev') }}"
                            x-on:click="slide(-1)"
                        >
                            <svg class="size-4" viewBox="0 0 18 12" fill="none" aria-hidden="true">
                                <path d="M17 6H1M1 6L6.5 1M1 6L6.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button
                            type="button"
                            class="inline-flex size-11 items-center justify-center rounded-full bg-beige-100 text-black-900 transition hover:bg-black-900 hover:text-beige-100"
                            aria-label="{{ __('site.about_page.blog_carousel_next') }}"
                            x-on:click="slide(1)"
                        >
                            <svg class="size-4" viewBox="0 0 18 12" fill="none" aria-hidden="true">
                                <path d="M1 6H17M17 6L11.5 1M17 6L11.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div
                    x-ref="track"
                    class="carousel-bleed-right flex cursor-grab gap-5 overflow-x-auto scroll-smooth pb-1 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden active:cursor-grabbing lg:gap-6"
                    role="list"
                    aria-label="{{ __('site.about_page.blog_carousel_label') }}"
                    x-on:pointerdown="onPointerDown($event)"
                    x-on:pointermove="onPointerMove($event)"
                    x-on:pointerup="onPointerUp($event)"
                    x-on:pointercancel="onPointerUp($event)"
                    x-on:click.capture="onClickCapture($event)"
                >
                    @foreach ($posts as $post)
                        <a
                            href="{{ $post['href'] }}"
                            data-card
                            role="listitem"
                            class="group flex w-[calc(100%-1.5rem)] shrink-0 select-none flex-col overflow-hidden rounded-[8px] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black-900 sm:w-[calc((100%-1.25rem)/1.6)] lg:w-[calc((100%-3rem)/2.4)]"
                        >
                            <img
                                src="{{ $post['image'] }}"
                                alt=""
                                class="pointer-events-none aspect-square w-full object-cover"
                                draggable="false"
                            >

                            <div class="relative flex items-start gap-3 bg-green-300 p-4">
                                <p class="line-clamp-3 flex-1 pr-2 text-b1 font-bold text-black-900">
                                    {{ $post['title'] }}
                                </p>

                                <span
                                    class="mt-0.5 inline-flex size-8 shrink-0 items-center justify-center rounded-full bg-beige-100 text-black-900 transition group-hover:bg-black-900 group-hover:text-beige-100"
                                    aria-hidden="true"
                                >
                                    <svg class="size-3.5" viewBox="0 0 16 16" fill="none">
                                        <path d="M4 12L12 4M12 4H6.5M12 4V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
