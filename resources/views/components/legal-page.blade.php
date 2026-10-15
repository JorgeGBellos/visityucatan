@props([
    'eyebrow' => null,
    'title',
    'updated' => null,
    'intro' => null,
    'sections' => [],
])

<main class="bg-beige-500 text-black-900">
    <article class="mx-auto max-w-site px-6 py-14 lg:px-10 lg:py-20">
        <div class="mx-auto max-w-3xl">
            <p class="text-label text-orange-500">{{ $eyebrow ?? __('site.legal.eyebrow') }}</p>
            <h1 class="mt-3 text-h3">{{ $title }}</h1>

            @if ($updated)
                <p class="mt-2 text-b3 font-book text-black-500">
                    {{ __('site.legal.updated', ['date' => $updated]) }}
                </p>
            @endif

            @if ($intro)
                <p class="mt-2 text-b1 font-book text-black-700">
                    {{ $intro }}
                </p>
            @endif

            <div class="mt-12 space-y-10">
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

            <div class="mt-16 border-t-2 border-black-900 pt-10">
                <p class="text-b2 font-book text-black-700">
                    {{ __('site.pages.legal_contact') }}
                </p>
                <div class="mt-6">
                    <x-button variant="secondary" href="{{ route('home') }}">
                        {{ __('site.common.back_home') }}
                    </x-button>
                </div>
            </div>
        </div>
    </article>
</main>
