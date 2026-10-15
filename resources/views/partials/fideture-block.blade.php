@php
    $titleId = $titleId ?? 'fideture-title';
    $title = $title ?? __('site.home.fideture_title');
    $text = $text ?? __('site.home.fideture_text');
    $cta = $cta ?? __('site.home.fideture_cta');
    $ctaHref = $ctaHref ?? route('pages.fideture');
    $sectionClass = $sectionClass ?? 'pb-16 lg:pb-24';
    $backgroundImage = $backgroundImage ?? 'images/home/Frame 106.png';
    $showGovernmentLockup = $showGovernmentLockup ?? true;
    $useRichText = $useRichText ?? false;
@endphp

<section class="bg-beige-500 {{ $sectionClass }}" aria-labelledby="{{ $titleId }}">
    <div class="mx-auto max-w-site md:px-6 lg:px-10">
        <div class="relative flex min-h-0 flex-col overflow-hidden rounded-none border-0 border-beige-100 md:rounded-lg md:border-2">
            <img
                src="{{ asset($backgroundImage) }}"
                alt=""
                class="absolute inset-0 h-full w-full object-cover"
                aria-hidden="true"
            >

            <div class="relative z-10 flex flex-col items-center px-6 py-16 text-center text-beige-100 sm:px-10 md:min-h-[640px] md:justify-center md:py-14">
                @if ($showGovernmentLockup)
                    <img
                        src="{{ asset('images/logotipos/yucatan-fideture.svg') }}"
                        alt="{{ __('site.fideture_page.block_image_alt') }}"
                        class="mb-8 h-auto w-[150px] md:mb-10 md:w-[170px]"
                        width="170"
                    >
                @endif

                <img
                    src="{{ asset('images/iconos/Fideture.svg') }}"
                    alt="Fideture"
                    class="h-auto w-[240px] md:w-[335px]"
                    width="335"
                    height="40"
                >

                <div class="mt-5 flex max-w-2xl flex-col items-center gap-3 md:mt-6">
                    <h2 id="{{ $titleId }}" class="text-s2 text-beige-100">
                        {{ $title }}
                    </h2>

                    <p class="text-b2 font-book text-beige-100/95">
                        @if ($useRichText)
                            {{ __('site.home.fideture_text_before') }}<strong class="font-bold">{{ __('site.home.fideture_text_bold_1') }}</strong>{{ __('site.home.fideture_text_middle') }}<strong class="font-bold">{{ __('site.home.fideture_text_bold_2') }}</strong>
                        @else
                            {{ $text }}
                        @endif
                    </p>
                </div>

                <a
                    href="{{ $ctaHref }}"
                    class="btn btn-sm mt-6 inline-flex w-full max-w-xs items-center justify-center gap-2 border-beige-100 bg-beige-100 text-[#811C3F] hover:border-black-900 hover:bg-black-900 hover:text-beige-100 sm:w-auto sm:max-w-none md:mt-8"
                >
                    <span>{{ $cta }}</span>
                    <svg class="btn-icon" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M4 12L12 4M12 4H6.5M12 4V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
