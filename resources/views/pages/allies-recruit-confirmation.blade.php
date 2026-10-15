@extends('layouts.site')

@section('title', __('site.ally_recruit.thanks_page_title').' — '.config('app.name'))
@section('body_class', 'bg-black-900')
@section('footer_mode', 'none')

@section('content')
    <main
        class="relative flex min-h-[calc(100vh-90px)] flex-col bg-black-900 bg-cover bg-center text-beige-100"
        style="background-image: url('{{ asset('images/confirmation.png') }}')"
    >
        <div class="absolute inset-0 bg-black-900/55" aria-hidden="true"></div>

        <div class="relative z-10 flex flex-1 flex-col items-center justify-center px-6 py-16 text-center lg:px-10">
            <div class="max-w-2xl">
                <img
                    src="{{ asset('images/svg/footerhero.svg') }}"
                    alt=""
                    class="mx-auto h-auto w-[100px]"
                    width="100"
                    height="62"
                    aria-hidden="true"
                >

                <h1 class="mt-8 text-h4 uppercase text-beige-100">
                    {{ __('site.ally_recruit.thanks_title') }}
                </h1>

                <p class="mt-2 text-s3 text-beige-100/90">
                    {{ __('site.ally_recruit.thanks_text') }}
                </p>

                <div class="mt-8 flex justify-center">
                    <x-button variant="tertiary" href="{{ route('home') }}">
                        {{ __('site.ally_recruit.thanks_cta') }}
                    </x-button>
                </div>
            </div>
        </div>

        <div class="relative z-10 mx-auto w-full max-w-site px-6 pb-8 lg:px-10">
            <div class="border-t border-beige-100/80 pt-6">
                <ul class="flex flex-wrap items-center justify-center gap-x-3 gap-y-2 text-b3 font-book text-beige-100">
                    <li>
                        <a href="{{ route('legal.terms') }}" class="transition-opacity hover:opacity-70">
                            {{ __('site.footer.terms') }}
                        </a>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-beige-100/60" aria-hidden="true">|</span>
                        <a href="{{ route('legal.cookies') }}" class="transition-opacity hover:opacity-70">
                            {{ __('site.footer.cookies') }}
                        </a>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-beige-100/60" aria-hidden="true">|</span>
                        <a href="{{ route('legal.privacy') }}" class="transition-opacity hover:opacity-70">
                            {{ __('site.footer.privacy') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </main>
@endsection
