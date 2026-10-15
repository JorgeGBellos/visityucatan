@php
    $titleId = $titleId ?? 'places-carousel-title';
    $eyebrow = $eyebrow ?? null;
    $title = $title ?? '';
    $text = $text ?? '';
    $cta = $cta ?? null;
    $ctaHref = $ctaHref ?? '#';
    $sectionClass = $sectionClass ?? 'py-16 lg:py-24';
    $sectionBg = $sectionBg ?? 'bg-beige-500';
    $footerBg = $footerBg ?? 'bg-beige-100';
    $navBtnClass = $navBtnClass ?? 'bg-beige-100 text-black-900 hover:bg-black-900 hover:text-beige-100';
    $items = $items ?? [];
    $icon = $icon ?? 'images/svg/casita.svg';
    $imageAspect = $imageAspect ?? 'aspect-square';
    $prevLabel = $prevLabel ?? 'Previous';
    $nextLabel = $nextLabel ?? 'Next';
    $carouselLabel = $carouselLabel ?? $title;
@endphp

@if ($items !== [])
    <section
        class="overflow-x-clip {{ $sectionBg }} {{ $sectionClass }}"
        aria-labelledby="{{ $titleId }}"
        x-data="siteCarousel"
    >
        <div class="mx-auto max-w-site px-6 lg:px-10">
            <div class="grid grid-cols-1 items-stretch gap-8 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,2.1fr)] lg:gap-12">
                <div class="flex flex-col items-start justify-center text-left text-black-900">
                    @if ($eyebrow)
                        <p class="text-btn3 font-book uppercase tracking-[0.04em] text-black-900">
                            {{ $eyebrow }}
                        </p>
                    @endif

                    <h2 id="{{ $titleId }}" @class(['text-s2 lg:text-s1', 'mt-3' => (bool) $eyebrow])>
                        {{ $title }}
                    </h2>

                    <p class="mt-3 max-w-md text-b2 font-book text-black-900">
                        {{ $text }}
                    </p>

                    @if ($cta)
                        <div class="mt-6">
                            <x-button variant="tertiary" class="border-black-900 bg-transparent" href="{{ $ctaHref }}">
                                {{ $cta }}
                            </x-button>
                        </div>
                    @endif

                    <div class="mt-8 flex items-center gap-3 lg:mt-10">
                        <button
                            type="button"
                            class="inline-flex size-11 items-center justify-center rounded-full {{ $navBtnClass }} transition"
                            aria-label="{{ $prevLabel }}"
                            x-on:click="slide(-1)"
                        >
                            <svg class="size-4" viewBox="0 0 18 12" fill="none" aria-hidden="true">
                                <path d="M17 6H1M1 6L6.5 1M1 6L6.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button
                            type="button"
                            class="inline-flex size-11 items-center justify-center rounded-full {{ $navBtnClass }} transition"
                            aria-label="{{ $nextLabel }}"
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
                    aria-label="{{ $carouselLabel }}"
                    x-on:pointerdown="onPointerDown($event)"
                    x-on:pointermove="onPointerMove($event)"
                    x-on:pointerup="onPointerUp($event)"
                    x-on:pointercancel="onPointerUp($event)"
                    x-on:click.capture="onClickCapture($event)"
                >
                    @foreach ($items as $item)
                        <article
                            data-card
                            role="listitem"
                            class="flex w-[calc(100%-1.5rem)] shrink-0 select-none flex-col overflow-hidden rounded-[8px] sm:w-[calc((100%-1.25rem)/1.6)] lg:w-[calc((100%-3rem)/2.4)]"
                        >
                            <img
                                src="{{ cms_asset($item['image']) }}"
                                alt="{{ $item['name'] }}"
                                class="pointer-events-none {{ $imageAspect }} w-full object-cover"
                                draggable="false"
                            >

                            <div class="relative flex min-h-[72px] items-center {{ $footerBg }} px-4 py-4 pr-12">
                                <p class="text-b1 font-bold text-black-900">
                                    {{ $item['name'] }}
                                </p>

                                <span
                                    class="absolute top-1/2 right-4 size-6 -translate-y-1/2 shrink-0 bg-black-900 [mask-image:var(--place-icon)] [mask-position:center] [mask-repeat:no-repeat] [mask-size:contain] [-webkit-mask-image:var(--place-icon)] [-webkit-mask-position:center] [-webkit-mask-repeat:no-repeat] [-webkit-mask-size:contain]"
                                    style="--place-icon: url('{{ asset($item['icon'] ?? $icon) }}')"
                                    aria-hidden="true"
                                ></span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
