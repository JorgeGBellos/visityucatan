@props([
    'eyebrow' => null,
    'title',
    'intro' => null,
    'sections' => [],
    'ctaLabel' => null,
    'ctaHref' => null,
    'showCta' => true,
])

@php
    $ctaHref = $ctaHref ?? route('pages.plan');
    $ctaLabel = $ctaLabel ?? __('site.common.plan_event');
@endphp

<main class="bg-beige-500 text-black-900">
    <header class="border-b-2 border-black-900">
        <div class="mx-auto max-w-site px-6 py-14 lg:px-10 lg:py-16">
            @if ($eyebrow)
                <p class="text-label text-orange-500">{{ $eyebrow }}</p>
            @endif
            <h1 @class(['text-h3', 'mt-3' => (bool) $eyebrow])>{{ $title }}</h1>
            @if ($intro)
                <p class="mt-2 max-w-3xl text-b1 font-book text-black-700">
                    {{ $intro }}
                </p>
            @endif
        </div>
    </header>

    <article class="mx-auto max-w-site px-6 py-14 lg:px-10 lg:py-20">
        <div class="mx-auto max-w-3xl">
            <div class="space-y-10">
                @foreach ($sections as $section)
                    <section @class([
                        'pt-8 border-t border-black-900/10' => ! $loop->first,
                    ])>
                        <h2 class="text-s2">{{ $section['heading'] }}</h2>

                        @foreach ($section['paragraphs'] ?? [] as $paragraph)
                            <p class="mt-2 text-b2 font-book text-black-700">
                                {{ $paragraph }}
                            </p>
                        @endforeach

                        @if (! empty($section['bullets']))
                            <ul class="mt-4 list-disc space-y-2 pl-5 text-b2 font-book text-black-700">
                                @foreach ($section['bullets'] as $bullet)
                                    <li>{{ $bullet }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </section>
                @endforeach
            </div>

            @if ($showCta)
                <div class="mt-16 border-t-2 border-black-900 pt-10">
                    <p class="text-b2 font-book text-black-700">
                        {{ __('site.pages.cta_hint') }}
                    </p>
                    <div class="mt-6">
                        <x-button variant="primary" href="{{ $ctaHref }}">
                            {{ $ctaLabel }}
                        </x-button>
                    </div>
                </div>
            @endif
        </div>
    </article>
</main>
