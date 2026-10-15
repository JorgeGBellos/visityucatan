@extends('layouts.site')

@section('title', $post->title().' — '.config('app.name'))
@section('body_class', 'bg-beige-500')

@section('content')
    <main class="bg-beige-500 text-black-900">
        <section class="w-full" aria-hidden="true">
            <div class="aspect-[21/9] w-full overflow-hidden bg-black-900 sm:aspect-[2.4/1] lg:aspect-[2.8/1]">
                <img
                    src="{{ $post->imageUrl() ?? asset('images/home/section4/images/card-1.png') }}"
                    alt=""
                    class="h-full w-full object-cover"
                >
            </div>
        </section>

        <article class="bg-beige-500 pb-16 pt-8 lg:pb-24 lg:pt-12" aria-labelledby="blog-post-title">
            <div class="mx-auto w-full max-w-4xl px-6 lg:px-10">
                <div class="flex items-start justify-between gap-6">
                    <p class="text-btn3 font-book uppercase tracking-[0.04em] text-black-900">
                        {{ $post->formattedDate() }}
                    </p>

                    <img
                        src="{{ asset('images/svg/doblesilla.svg') }}"
                        alt=""
                        class="h-8 w-auto shrink-0 opacity-90"
                        height="32"
                        aria-hidden="true"
                    >
                </div>

                <h1 id="blog-post-title" class="mt-6 text-s1 text-black-900 lg:mt-8 lg:text-h4">
                    {{ $post->title() }}
                </h1>

                <div
                    class="blog-body mt-8 space-y-6 text-b2 font-book leading-relaxed text-black-900 lg:mt-10
                        [&_a]:underline [&_a]:underline-offset-2
                        [&_figure]:my-10 [&_figure]:w-full
                        [&_h2]:mt-12 [&_h2]:text-s1 [&_h2]:leading-snug [&_h2]:text-black-900 lg:[&_h2]:mt-14
                        [&_h3]:mt-8 [&_h3]:text-b2 [&_h3]:font-bold [&_h3]:leading-relaxed
                        [&_img]:block [&_img]:h-auto [&_img]:w-full [&_img]:object-cover
                        [&_p]:max-w-none"
                >
                    {!! $post->body() !!}
                </div>

                <div class="mt-14 border-y border-black-900 py-4 lg:mt-16">
                    <div class="flex flex-wrap items-center justify-between gap-x-6 gap-y-2">
                        <p class="text-btn3 font-book uppercase tracking-[0.04em] text-black-900">
                            {{ $post->formattedDate() }}
                        </p>
                        <p class="text-btn3 font-book uppercase tracking-[0.04em] text-black-900">
                            {{ $post->author ?: __('site.blog_page.default_author') }}
                        </p>
                    </div>
                </div>

                <div class="mt-10">
                    <a
                        href="{{ route('pages.blog') }}"
                        class="inline-flex items-center gap-2 text-b2 font-bold text-black-900 transition-opacity hover:opacity-70"
                    >
                        <svg class="size-4 rotate-180" viewBox="0 0 18 12" fill="none" aria-hidden="true">
                            <path d="M1 6H17M17 6L11.5 1M17 6L11.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>{{ __('site.blog_page.back') }}</span>
                    </a>
                </div>
            </div>
        </article>
    </main>
@endsection
