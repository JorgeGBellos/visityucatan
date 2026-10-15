{{--
  Carrusel de aliados (home / por qué Yucatán).
  Requiere $aliados: array de items con name, description, phone, website, image, href; opcional bodyClass.
--}}
@php
    $sectionClass = $sectionClass ?? 'pt-16 pb-16 lg:pt-0 lg:pb-24';
    $sectionBg = $sectionBg ?? 'bg-beige-500';
    $bodyClasses = ['bg-yellow-100', 'bg-orange-100', 'bg-green-100'];
@endphp
<section
    class="overflow-x-clip {{ $sectionBg }} {{ $sectionClass }}"
    aria-labelledby="{{ $titleId ?? 'aliados-title' }}"
    x-data="siteCarousel"
>
    <div class="mx-auto max-w-site px-6 lg:px-10">
        <div class="grid grid-cols-1 items-stretch gap-8 lg:grid-cols-[minmax(0,0.7fr)_minmax(0,2.3fr)] lg:items-center lg:gap-12">
            <div class="flex flex-col justify-between text-black-900 lg:min-h-[28rem] lg:py-4">
                <div>
                    <h2 id="{{ $titleId ?? 'aliados-title' }}" class="text-s1">
                        {{ $title ?? __('site.home.aliados_title') }}
                    </h2>
                    <p class="mt-2 text-b2 font-book text-black-700">
                        {{ $text ?? __('site.home.aliados_text') }}
                    </p>
                    @if (! empty($text2))
                        <p class="mt-2 text-b2 font-book text-black-700">
                            {{ $text2 }}
                        </p>
                    @endif

                    <div class="mt-8 hidden items-center gap-3 lg:flex">
                        <button
                            type="button"
                            class="inline-flex size-11 items-center justify-center rounded-full bg-yellow-100 text-black-900 transition hover:bg-yellow-300"
                            aria-label="{{ __('site.home.aliados_prev') }}"
                            x-on:click="slide(-1)"
                        >
                            <svg class="size-4" viewBox="0 0 18 12" fill="none" aria-hidden="true">
                                <path d="M17 6H1M1 6L6.5 1M1 6L6.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button
                            type="button"
                            class="inline-flex size-11 items-center justify-center rounded-full bg-yellow-100 text-black-900 transition hover:bg-yellow-300"
                            aria-label="{{ __('site.home.aliados_next') }}"
                            x-on:click="slide(1)"
                        >
                            <svg class="size-4" viewBox="0 0 18 12" fill="none" aria-hidden="true">
                                <path d="M1 6H17M17 6L11.5 1M17 6L11.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="mt-8 lg:mt-10">
                    <x-button variant="tertiary" class="w-full border-black-900 lg:w-auto" href="{{ route('pages.allies') }}">
                        {{ $cta ?? __('site.home.aliados_cta') }}
                    </x-button>
                </div>
            </div>

            <div
                x-ref="track"
                class="carousel-bleed-right flex cursor-grab gap-6 overflow-x-auto scroll-smooth pb-1 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden active:cursor-grabbing"
                role="list"
                aria-label="{{ __('site.home.aliados_carousel') }}"
                x-on:pointerdown="onPointerDown($event)"
                x-on:pointermove="onPointerMove($event)"
                x-on:pointerup="onPointerUp($event)"
                x-on:pointercancel="onPointerUp($event)"
                x-on:click.capture="onClickCapture($event)"
            >
                @foreach ($aliados as $index => $aliado)
                    @php
                        $bodyClass = $aliado['bodyClass'] ?? $bodyClasses[$index % count($bodyClasses)];
                        $websiteUrl = $aliado['href'] ?? '#';
                        $phoneHref = 'tel:' . preg_replace('/[^\d+]/', '', $aliado['phone'] ?? '');
                    @endphp
                    <article
                        data-card
                        role="listitem"
                        class="flex w-[calc(100%-1.5rem)] shrink-0 flex-col overflow-hidden rounded-2xl sm:w-[calc((100%-3rem)/2.5)] lg:w-[calc((100%-3.75rem)/3.5)] select-none"
                    >
                        <div class="flex aspect-[355/260] items-center justify-center bg-beige-100 px-6 py-8">
                            <img
                                src="{{ cms_asset($aliado['image']) }}"
                                alt="{{ $aliado['name'] }}"
                                class="pointer-events-none max-h-full max-w-full object-contain"
                                draggable="false"
                            >
                        </div>

                        <div class="flex flex-1 flex-col gap-3 {{ $bodyClass }} p-5 text-black-900">
                            <h3 class="text-s2 leading-snug">
                                {{ $aliado['name'] }}
                            </h3>
                            <p class="text-b2 font-book leading-snug text-black-700">
                                {{ $aliado['description'] }}
                            </p>

                            <ul class="mt-auto space-y-2 pt-1 text-b2 font-book text-black-700">
                                <li>
                                    <a href="{{ $phoneHref }}" class="inline-flex items-center gap-2 transition hover:opacity-70">
                                        <svg class="size-4 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                            <path d="M4.85 1.7H6.55L7.5 4.45L5.85 5.45C6.5 6.85 7.65 8 9.05 8.65L10.05 7L12.8 7.95V9.65C12.8 10.4 12.2 11 11.45 11C6.85 11 3.1 7.25 3.1 2.65C3.1 1.9 3.7 1.3 4.45 1.3L4.85 1.7Z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>{{ $aliado['phone'] }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a
                                        href="{{ $websiteUrl }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 transition hover:opacity-70"
                                    >
                                        <svg class="size-4 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                            <circle cx="8" cy="8" r="5.25" stroke="currentColor" stroke-width="1.2"/>
                                            <path d="M2.75 8H13.25M8 2.75C9.5 4.4 10.25 6.1 10.25 8C10.25 9.9 9.5 11.6 8 13.25C6.5 11.6 5.75 9.9 5.75 8C5.75 6.1 6.5 4.4 8 2.75Z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>{{ $aliado['website'] }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="flex items-center gap-3 lg:hidden">
                <button
                    type="button"
                    class="inline-flex size-11 items-center justify-center rounded-full bg-yellow-100 text-black-900 transition hover:bg-yellow-300"
                    aria-label="{{ __('site.home.aliados_prev') }}"
                    x-on:click="slide(-1)"
                >
                    <svg class="size-4" viewBox="0 0 18 12" fill="none" aria-hidden="true">
                        <path d="M17 6H1M1 6L6.5 1M1 6L6.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button
                    type="button"
                    class="inline-flex size-11 items-center justify-center rounded-full bg-yellow-100 text-black-900 transition hover:bg-yellow-300"
                    aria-label="{{ __('site.home.aliados_next') }}"
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
