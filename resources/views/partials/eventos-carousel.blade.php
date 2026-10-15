@php
    $titleId = $titleId ?? 'eventos-title';
    $title = $title ?? __('site.home.eventos_title');
    $text = $text ?? __('site.home.eventos_text');
@endphp

<section
    class="overflow-x-clip bg-beige-500 pt-8 pb-16 lg:pt-0 lg:pb-24"
    aria-labelledby="{{ $titleId }}"
    x-data="siteCarousel"
>
    <div class="mx-auto max-w-site px-6 lg:px-10">
        <div class="grid grid-cols-1 items-stretch gap-8 lg:grid-cols-[minmax(0,0.85fr)_minmax(0,2.15fr)] lg:gap-12">
            <div class="flex flex-col justify-between text-black-900">
                <div>
                    <h2 id="{{ $titleId }}" class="text-s2 lg:text-s1">
                        {{ $title }}
                    </h2>
                    <p class="mt-2 text-b2 font-book text-black-700">
                        {{ $text }}
                    </p>
                </div>

                <div class="mt-8 hidden items-center gap-3 lg:mt-10 lg:flex">
                    <button
                        type="button"
                        class="inline-flex size-11 items-center justify-center rounded-full bg-beige-100 text-black-900 transition hover:bg-black-900 hover:text-beige-100"
                        aria-label="{{ __('site.home.eventos_prev') }}"
                        x-on:click="slide(-1)"
                    >
                        <svg class="size-4" viewBox="0 0 18 12" fill="none" aria-hidden="true">
                            <path d="M17 6H1M1 6L6.5 1M1 6L6.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button
                        type="button"
                        class="inline-flex size-11 items-center justify-center rounded-full bg-beige-100 text-black-900 transition hover:bg-black-900 hover:text-beige-100"
                        aria-label="{{ __('site.home.eventos_next') }}"
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
                class="carousel-bleed-right flex cursor-grab gap-6 overflow-x-auto scroll-smooth pb-1 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden active:cursor-grabbing"
                role="list"
                aria-label="{{ __('site.home.eventos_carousel') }}"
                x-on:pointerdown="onPointerDown($event)"
                x-on:pointermove="onPointerMove($event)"
                x-on:pointerup="onPointerUp($event)"
                x-on:pointercancel="onPointerUp($event)"
                x-on:click.capture="onClickCapture($event)"
            >
                @foreach ($eventos as $evento)
                    <article
                        data-card
                        role="listitem"
                        class="w-[calc(100%-1.5rem)] shrink-0 select-none overflow-hidden rounded-lg sm:w-[calc((100%-1.5rem)/1.8)] lg:w-[calc((100%-3rem)/2.5)]"
                    >
                        <img
                            src="{{ asset($evento['image']) }}"
                            alt=""
                            class="pointer-events-none aspect-square w-full rounded-t-lg object-cover"
                            draggable="false"
                        >

                        <div class="relative bg-beige-100 px-4 py-4">
                            <p class="pr-10 text-b2 font-bold text-black-900">
                                {{ $evento['title'] }}
                            </p>
                            <p class="mt-1 pr-10 text-b2 font-book text-black-700">
                                {{ $evento['description'] }}
                            </p>
                            <img
                                src="{{ asset($evento['icon']) }}"
                                alt=""
                                class="absolute top-4 right-4 size-6 object-contain"
                                width="24"
                                height="24"
                                aria-hidden="true"
                            >
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="flex items-center gap-3 lg:hidden">
                <button
                    type="button"
                    class="inline-flex size-11 items-center justify-center rounded-full bg-beige-100 text-black-900 transition hover:bg-black-900 hover:text-beige-100"
                    aria-label="{{ __('site.home.eventos_prev') }}"
                    x-on:click="slide(-1)"
                >
                    <svg class="size-4" viewBox="0 0 18 12" fill="none" aria-hidden="true">
                        <path d="M17 6H1M1 6L6.5 1M1 6L6.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button
                    type="button"
                    class="inline-flex size-11 items-center justify-center rounded-full bg-beige-100 text-black-900 transition hover:bg-black-900 hover:text-beige-100"
                    aria-label="{{ __('site.home.eventos_next') }}"
                    x-on:click="slide(1)"
                >
                    <svg class="size-4" viewBox="0 0 18 12" fill="none" aria-hidden="true">
                        <path d="M1 6H17M17 6L11.5 1M17 6L11.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>
