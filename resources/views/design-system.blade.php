@extends('layouts.app')

@section('title', 'Design System — ' . config('app.name'))

@section('content')
    @php
        $nav = [
            ['id' => 'fundamentos', 'label' => 'Fundamentos'],
            ['id' => 'colores', 'label' => 'Colores'],
            ['id' => 'tipografia', 'label' => 'Tipografía'],
            ['id' => 'botones', 'label' => 'Botones'],
        ];

        $palettes = [
            'Yellow' => [
                ['token' => 'yellow-700', 'hex' => '#D9A700', 'bg' => 'bg-yellow-700'],
                ['token' => 'yellow-500', 'hex' => '#F8C100', 'bg' => 'bg-yellow-500'],
                ['token' => 'yellow-300', 'hex' => '#FFE082', 'bg' => 'bg-yellow-300'],
                ['token' => 'yellow-100', 'hex' => '#FFF0BF', 'bg' => 'bg-yellow-100'],
            ],
            'Orange' => [
                ['token' => 'orange-700', 'hex' => '#B85A1D', 'bg' => 'bg-orange-700'],
                ['token' => 'orange-500', 'hex' => '#D56E26', 'bg' => 'bg-orange-500'],
                ['token' => 'orange-300', 'hex' => '#F4A06A', 'bg' => 'bg-orange-300'],
                ['token' => 'orange-100', 'hex' => '#FFE0CC', 'bg' => 'bg-orange-100'],
            ],
            'Green' => [
                ['token' => 'green-700', 'hex' => '#596E2F', 'bg' => 'bg-green-700'],
                ['token' => 'green-500', 'hex' => '#6D8639', 'bg' => 'bg-green-500'],
                ['token' => 'green-300', 'hex' => '#AAC17B', 'bg' => 'bg-green-300'],
                ['token' => 'green-100', 'hex' => '#E3ECD0', 'bg' => 'bg-green-100'],
            ],
            'Blue' => [
                ['token' => 'blue-700', 'hex' => '#3578A2', 'bg' => 'bg-blue-700'],
                ['token' => 'blue-500', 'hex' => '#4392C6', 'bg' => 'bg-blue-500'],
                ['token' => 'blue-300', 'hex' => '#7FBDE3', 'bg' => 'bg-blue-300'],
                ['token' => 'blue-100', 'hex' => '#D6EBF7', 'bg' => 'bg-blue-100'],
            ],
            'Beige' => [
                ['token' => 'beige-500', 'hex' => '#F0EBDD', 'bg' => 'bg-beige-500'],
                ['token' => 'beige-300', 'hex' => '#F8F5EF', 'bg' => 'bg-beige-300'],
                ['token' => 'beige-100', 'hex' => '#FFFFFF', 'bg' => 'bg-beige-100'],
            ],
            'Black' => [
                ['token' => 'black-900', 'hex' => '#141112', 'bg' => 'bg-black-900'],
                ['token' => 'black-700', 'hex' => '#212121', 'bg' => 'bg-black-700'],
                ['token' => 'black-500', 'hex' => '#444444', 'bg' => 'bg-black-500'],
                ['token' => 'black-300', 'hex' => '#B8AEAB', 'bg' => 'bg-black-300'],
                ['token' => 'black-100', 'hex' => '#EAE5E3', 'bg' => 'bg-black-100'],
            ],
        ];

        $headlines = [
            ['class' => 'text-h1', 'name' => 'H1', 'mobile' => '40 / 48', 'desktop' => '48 / 64'],
            ['class' => 'text-h2', 'name' => 'H2', 'mobile' => '36 / 43', 'desktop' => '40 / 56'],
            ['class' => 'text-h3', 'name' => 'H3', 'mobile' => '32 / 38', 'desktop' => '36 / 48'],
            ['class' => 'text-h4', 'name' => 'H4', 'mobile' => '28 / 34', 'desktop' => '32 / 40'],
        ];

        $subtitles = [
            ['class' => 'text-s1', 'name' => 'S1', 'mobile' => '24 / 29', 'desktop' => '28 / 36'],
            ['class' => 'text-s2', 'name' => 'S2', 'mobile' => '20 / 24', 'desktop' => '24 / 32'],
            ['class' => 'text-s3', 'name' => 'S3', 'mobile' => '18 / 24', 'desktop' => '20 / 32'],
        ];

        $bodies = [
            ['class' => 'text-b1', 'name' => 'B1', 'size' => '18 / 24'],
            ['class' => 'text-b2', 'name' => 'B2', 'size' => '16 / 24'],
            ['class' => 'text-b3', 'name' => 'B3', 'size' => '14 / 20'],
        ];

        $buttonSizes = [
            ['size' => 'lg', 'name' => 'Btn1 / lg', 'meta' => '18 / 24'],
            ['size' => 'md', 'name' => 'Btn2 / md', 'meta' => '16 / 24'],
            ['size' => 'sm', 'name' => 'Btn3 / sm', 'meta' => '14 / 20'],
        ];

        $buttonVariants = [
            ['variant' => 'primary', 'label' => 'Primary', 'note' => 'black-900'],
            ['variant' => 'green', 'label' => 'Green', 'note' => 'green-500'],
            ['variant' => 'secondary', 'label' => 'Secondary', 'note' => 'white + borde'],
            ['variant' => 'tertiary', 'label' => 'Tertiary', 'note' => 'beige-500'],
            ['variant' => 'auxiliar', 'label' => 'Auxiliar', 'note' => 'ghost'],
            ['variant' => 'auxiliar-green', 'label' => 'Auxiliar green', 'note' => 'ghost green-500'],
        ];
    @endphp

    <div
        class="min-h-screen bg-beige-300 text-green-700"
        x-data="{ section: 'fundamentos' }"
        x-init="
            const ids = {{ Js::from(collect($nav)->pluck('id')) }};
            const onScroll = () => {
                let current = ids[0];
                for (const id of ids) {
                    const el = document.getElementById(id);
                    if (el && el.getBoundingClientRect().top <= 120) current = id;
                }
                section = current;
            };
            onScroll();
            window.addEventListener('scroll', onScroll, { passive: true });
        "
    >
        <header class="border-b border-green-700/10 bg-beige-300/90 backdrop-blur-sm sticky top-0 z-10">
            <div class="mx-auto max-w-5xl px-6 py-4 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-label text-orange-500">{{ config('app.name') }}</p>
                    <p class="text-s3">Design System</p>
                </div>
                <nav class="flex flex-wrap gap-x-5 gap-y-2" aria-label="Secciones">
                    @foreach ($nav as $item)
                        <a
                            href="#{{ $item['id'] }}"
                            class="text-btn3 transition-colors"
                            :class="section === '{{ $item['id'] }}' ? 'font-bold text-orange-500' : 'font-book text-green-500 hover:text-green-700'"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-5xl px-6 py-12 space-y-20">
            {{-- Fundamentos --}}
            <section id="fundamentos" class="scroll-mt-24 space-y-8">
                <div class="space-y-3 max-w-2xl">
                    <h1 class="text-h1">Fundamentos</h1>
                    <p class="text-b1 font-book text-green-500">
                        Tokens de marca para tipografía y color. Usa las clases semánticas en Blade o Livewire.
                    </p>
                </div>

                <div class="grid gap-10 md:grid-cols-2">
                    <div class="space-y-3">
                        <p class="text-label text-blue-500">Display · títulos y subtítulos</p>
                        <p class="text-h3">Clarendon</p>
                        <p class="text-b2 font-book text-green-500">
                            Clases <span class="font-bold text-green-700">text-h1…h4</span>,
                            <span class="font-bold text-green-700">text-s1…s3</span>.
                            Peso Medium (500). Archivo: <code class="text-b3">public/fonts/clarendon/</code>
                        </p>
                    </div>
                    <div class="space-y-3">
                        <p class="text-label text-blue-500">Sans · body, botones y labels</p>
                        <p class="font-sans font-book text-[2rem] leading-[1.2] md:text-[2.25rem]">Circular Std</p>
                        <p class="text-b2 font-book text-green-500">
                            Clases <span class="font-bold text-green-700">text-b1…b3</span>,
                            <span class="font-bold text-green-700">text-btn1…btn3</span>,
                            <span class="font-bold text-green-700">text-label</span>.
                            Pesos Book / Bold. Archivo: <code class="text-b3">public/fonts/circular/</code>
                        </p>
                    </div>
                </div>
            </section>

            {{-- Colores --}}
            <section id="colores" class="scroll-mt-24 space-y-10">
                <div class="space-y-3 max-w-2xl">
                    <h2 class="text-h2">Colores</h2>
                    <p class="text-b2 font-book text-green-500">
                        Utilidades Tailwind: <code class="text-b3">bg-*</code>, <code class="text-b3">text-*</code>, <code class="text-b3">border-*</code>.
                    </p>
                </div>

                @foreach ($palettes as $name => $swatches)
                    <div class="space-y-4">
                        <h3 class="text-s2">{{ $name }}</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            @foreach ($swatches as $swatch)
                                <div class="space-y-2">
                                    <div class="h-20 w-full {{ $swatch['bg'] }} border border-green-700/10"></div>
                                    <p class="text-label">{{ $swatch['token'] }}</p>
                                    <p class="text-b3 font-book text-green-500">{{ $swatch['hex'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </section>

            {{-- Tipografía --}}
            <section id="tipografia" class="scroll-mt-24 space-y-12">
                <div class="space-y-3 max-w-2xl">
                    <h2 class="text-h2">Tipografía</h2>
                    <p class="text-b2 font-book text-green-500">
                        Tamaños en px: móvil → desktop (donde aplica). Formato size / line-height.
                    </p>
                </div>

                <div class="space-y-8">
                    <h3 class="text-s2">Headlines</h3>
                    @foreach ($headlines as $item)
                        <div class="space-y-2 border-b border-green-700/10 pb-6">
                            <div class="flex flex-wrap items-baseline justify-between gap-2">
                                <p class="text-label text-orange-500">{{ $item['name'] }} · {{ $item['class'] }} · Medium</p>
                                <p class="text-b3 font-book text-green-500">
                                    móvil {{ $item['mobile'] }} · desktop {{ $item['desktop'] }}
                                </p>
                            </div>
                            <p class="{{ $item['class'] }}">{{ $item['name'] }}. Headline</p>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-8">
                    <h3 class="text-s2">Subtitles</h3>
                    @foreach ($subtitles as $item)
                        <div class="space-y-2 border-b border-green-700/10 pb-6">
                            <div class="flex flex-wrap items-baseline justify-between gap-2">
                                <p class="text-label text-orange-500">{{ $item['name'] }} · {{ $item['class'] }} · Medium</p>
                                <p class="text-b3 font-book text-green-500">
                                    móvil {{ $item['mobile'] }} · desktop {{ $item['desktop'] }}
                                </p>
                            </div>
                            <p class="{{ $item['class'] }}">{{ $item['name'] }}. Subtitle</p>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-8">
                    <h3 class="text-s2">Body</h3>
                    @foreach ($bodies as $item)
                        <div class="space-y-3 border-b border-green-700/10 pb-6">
                            <div class="flex flex-wrap items-baseline justify-between gap-2">
                                <p class="text-label text-orange-500">{{ $item['name'] }} · {{ $item['class'] }}</p>
                                <p class="text-b3 font-book text-green-500">{{ $item['size'] }} · Book / Bold</p>
                            </div>
                            <p class="{{ $item['class'] }} font-book">{{ $item['name'] }}. Body Book — Yucatán invita a explorar.</p>
                            <p class="{{ $item['class'] }} font-bold">{{ $item['name'] }}. Body Bold — Yucatán invita a explorar.</p>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-4 border-b border-green-700/10 pb-6">
                    <div class="flex flex-wrap items-baseline justify-between gap-2">
                        <p class="text-label text-orange-500">L1 · text-label · Medium</p>
                        <p class="text-b3 font-book text-green-500">14 / 16</p>
                    </div>
                    <p class="text-label">Label — categoría, meta, eyebrow</p>
                </div>
            </section>

            {{-- Botones --}}
            <section id="botones" class="scroll-mt-24 space-y-12">
                <div class="space-y-3 max-w-2xl">
                    <h2 class="text-h2">Botones</h2>
                    <p class="text-b2 font-book text-green-500">
                        Componente <code class="text-b3">&lt;x-button&gt;</code>.
                        Variantes: primary, green, secondary, tertiary, auxiliar.
                        Flechas opcionales: <code class="text-b3">arrow="left|right"</code>.
                    </p>
                </div>

                <div class="space-y-6">
                    <h3 class="text-s2">Variantes</h3>
                    <div class="grid gap-6 sm:grid-cols-2">
                        @foreach ($buttonVariants as $item)
                            <div class="space-y-3 border-b border-green-700/10 pb-6">
                                <div class="flex flex-wrap items-baseline justify-between gap-2">
                                    <p class="text-label text-orange-500">{{ $item['label'] }}</p>
                                    <p class="text-b3 font-book text-green-500">{{ $item['note'] }}</p>
                                </div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <x-button :variant="$item['variant']">Button</x-button>
                                    <x-button :variant="$item['variant']" arrow="right">Button</x-button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-s2">Auxiliar · dirección de flecha</h3>
                    <div class="flex flex-wrap items-center gap-8 border-b border-green-700/10 pb-6">
                        <x-button variant="auxiliar">Button</x-button>
                        <x-button variant="auxiliar-green">Button</x-button>
                        <x-button variant="auxiliar" arrow="right">Button</x-button>
                        <x-button variant="auxiliar" arrow="right" class="font-bold">Button</x-button>
                        <x-button variant="auxiliar" arrow="left">Button</x-button>
                        <x-button variant="auxiliar" arrow="left" class="font-bold">Button</x-button>
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-s2">Tamaños</h3>
                    @foreach ($buttonSizes as $item)
                        <div class="space-y-3 border-b border-green-700/10 pb-6">
                            <div class="flex flex-wrap items-baseline justify-between gap-2">
                                <p class="text-label text-orange-500">{{ $item['name'] }}</p>
                                <p class="text-b3 font-book text-green-500">{{ $item['meta'] }}</p>
                            </div>
                            <div class="flex flex-wrap items-center gap-3">
                                <x-button variant="primary" :size="$item['size']">Primary</x-button>
                                <x-button variant="secondary" :size="$item['size']">Secondary</x-button>
                                <x-button variant="tertiary" :size="$item['size']" arrow="right">Tertiary</x-button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <footer class="border-t border-green-700/10 pt-8 pb-4 flex flex-wrap gap-6">
                <a href="{{ route('home') }}" class="text-btn3 font-book text-green-500 underline underline-offset-4 hover:text-green-700">
                    Inicio
                </a>
                <a href="{{ url('/admin') }}" class="text-btn3 font-book text-green-500 underline underline-offset-4 hover:text-green-700">
                    Admin
                </a>
            </footer>
        </main>
    </div>
@endsection
