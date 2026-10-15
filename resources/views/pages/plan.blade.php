@extends('layouts.site')

@section('title', __('site.common.plan_event').' — '.config('app.name'))
@section('body_class', 'bg-beige-500')

@section('footer')
    <x-site-footer :show-hero="false" background="beige" />
@endsection

@section('content')
    @php
        $field = 'w-full rounded-lg bg-beige-100 px-4 py-3.5 text-b2 font-book text-black-900 outline-none transition border border-transparent focus:border-black-900 lg:mt-2 lg:rounded-none lg:bg-beige-500 lg:py-3';
        $helpOptions = __('site.plan.help');
        $oldHelp = old('help', []);

        $initialStep = 1;
        if ($errors->hasAny(['event_name', 'event_type', 'estimated_date', 'attendees', 'origin', 'has_venue', 'message'])) {
            $initialStep = 2;
        }
        if ($errors->has('help') || $errors->has('help.*')) {
            $initialStep = 3;
        }
    @endphp

    <main
        class="bg-beige-500 text-black-900"
        x-data="{
            step: {{ $initialStep }},
            isDesktop: false,
            fullName: {{ Js::from(trim(old('first_name', '').' '.old('last_name', ''))) }},
            init() {
                const mq = window.matchMedia('(min-width: 1024px)');
                this.isDesktop = mq.matches;
                mq.addEventListener('change', (e) => { this.isDesktop = e.matches; });
                if (!this.isDesktop) this.syncName();
            },
            syncName() {
                const parts = this.fullName.trim().split(/\s+/).filter(Boolean);
                const first = parts[0] || '';
                const last = parts.length > 1 ? parts.slice(1).join(' ') : first;
                if (this.$refs.firstName) this.$refs.firstName.value = first;
                if (this.$refs.lastName) this.$refs.lastName.value = last;
            },
            validateStep(step) {
                const root = this.$refs['step' + step];
                if (!root) return true;
                if (step === 1 && !this.isDesktop) this.syncName();
                const fields = [...root.querySelectorAll('input, select, textarea')].filter((field) => {
                    if (field.disabled || field.type === 'checkbox' || field.type === 'hidden') return false;
                    if (!this.isDesktop && (field.name === 'first_name' || field.name === 'last_name')) return false;
                    if (this.isDesktop && field.name === 'full_name') return false;
                    return true;
                });
                for (const field of fields) {
                    if (!field.checkValidity()) {
                        field.reportValidity();
                        return false;
                    }
                }
                return true;
            },
            next() {
                if (!this.validateStep(this.step)) return;
                if (this.step < 3) this.step += 1;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }"
    >
        {{-- Cintilla 1: iconos + título --}}
        <section class="bg-beige-500 pb-16 pt-14 lg:pb-0 lg:pt-20" aria-labelledby="plan-title">
            <div class="overflow-hidden" aria-hidden="true">
                {{-- Móvil: 2 cintillas en sentidos opuestos --}}
                <div class="flex flex-col gap-6 lg:hidden">
                    <div class="overflow-hidden">
                        <div class="flex w-max animate-cintilla-reverse will-change-transform">
                            @foreach ([1, 2] as $copy)
                                <div class="shrink-0 pr-12">
                                    <img
                                        src="{{ asset('images/svg/cintilla.svg') }}"
                                        alt=""
                                        class="block h-[72px] w-auto max-w-none sm:h-[88px]"
                                        width="1920"
                                        height="100"
                                    >
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="overflow-hidden">
                        <div class="flex w-max animate-cintilla will-change-transform">
                            @foreach ([1, 2] as $copy)
                                <div class="shrink-0 pr-12">
                                    <img
                                        src="{{ asset('images/svg/cintilla.svg') }}"
                                        alt=""
                                        class="block h-[72px] w-auto max-w-none sm:h-[88px]"
                                        width="1920"
                                        height="100"
                                    >
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Desktop: una sola cintilla --}}
                <div class="hidden lg:block">
                    <div class="flex w-max animate-cintilla">
                        <div class="shrink-0 pr-16">
                            <img
                                src="{{ asset('images/svg/cintilla.svg') }}"
                                alt=""
                                class="h-[90px] w-auto max-w-none"
                                width="1920"
                                height="100"
                            >
                        </div>
                        <div class="shrink-0 pr-16">
                            <img
                                src="{{ asset('images/svg/cintilla.svg') }}"
                                alt=""
                                class="h-[90px] w-auto max-w-none"
                                width="1920"
                                height="100"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="mx-auto max-w-site px-6 pt-14 text-center lg:px-10 lg:pt-16">
                <div class="mx-auto max-w-4xl">
                    <h1 id="plan-title" class="text-s2 uppercase lg:text-s1 lg:normal-case">
                        {{ __('site.plan.title') }}
                    </h1>
                    <p class="mx-auto mt-5 max-w-xl text-b2 font-book text-black-700 lg:mt-4 lg:max-w-none">
                        {{ __('site.plan.intro') }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Cintilla 2: formulario --}}
        <section class="bg-green-500 py-10 lg:bg-beige-500 lg:py-20" aria-label="{{ __('site.common.plan_event') }}">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="mx-auto max-w-4xl lg:rounded-lg lg:bg-beige-100 lg:p-8">
                    @if ($errors->any())
                        <div class="mb-6 border-2 border-orange-500 bg-orange-100 px-4 py-3 text-b3 font-book text-black-900" role="alert">
                            {{ __('site.plan.errors') }}
                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('pages.plan.store') }}"
                        class="space-y-0 lg:space-y-10"
                        @submit="if (!isDesktop) syncName()"
                    >
                        @csrf

                        {{-- Paso 1 --}}
                        <fieldset x-ref="step1" x-show="isDesktop || step === 1" x-cloak class="min-w-0">
                            <legend class="w-full">
                                <span class="block text-btn3 font-book uppercase tracking-[0.04em] text-black-900 lg:hidden">
                                    {{ __('site.plan.step', ['step' => 1]) }}
                                </span>
                                <span class="mt-2 block text-s2 lg:mt-0">{{ __('site.plan.section_personal') }}</span>
                            </legend>

                            <div class="mt-6 space-y-4">
                                <div class="lg:hidden">
                                    <label for="full_name" class="sr-only">{{ __('site.plan.full_name') }}</label>
                                    <input
                                        id="full_name"
                                        name="full_name"
                                        type="text"
                                        x-model="fullName"
                                        @input="syncName()"
                                        placeholder="{{ __('site.plan.full_name') }}"
                                        class="{{ $field }}"
                                        :required="!isDesktop"
                                        :disabled="isDesktop"
                                    >
                                </div>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class="hidden lg:block">
                                        <label for="first_name" class="sr-only">{{ __('site.plan.first_name') }}</label>
                                        <input
                                            id="first_name"
                                            name="first_name"
                                            type="text"
                                            x-ref="firstName"
                                            value="{{ old('first_name') }}"
                                            placeholder="{{ __('site.plan.first_name') }}"
                                            class="{{ $field }}"
                                            :required="isDesktop"
                                        >
                                        @error('first_name')
                                            <p class="mt-2 text-b3 font-book text-orange-700">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="hidden lg:block">
                                        <label for="last_name" class="sr-only">{{ __('site.plan.last_name') }}</label>
                                        <input
                                            id="last_name"
                                            name="last_name"
                                            type="text"
                                            x-ref="lastName"
                                            value="{{ old('last_name') }}"
                                            placeholder="{{ __('site.plan.last_name') }}"
                                            class="{{ $field }}"
                                            :required="isDesktop"
                                        >
                                        @error('last_name')
                                            <p class="mt-2 text-b3 font-book text-orange-700">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="sm:col-span-2 lg:col-span-1">
                                        <label for="company" class="sr-only">{{ __('site.plan.company') }}</label>
                                        <input id="company" name="company" type="text" value="{{ old('company') }}" placeholder="{{ __('site.plan.company') }}" class="{{ $field }}">
                                    </div>
                                    <div class="sm:col-span-2 lg:col-span-1">
                                        <label for="position" class="sr-only">{{ __('site.plan.position') }}</label>
                                        <input id="position" name="position" type="text" value="{{ old('position') }}" placeholder="{{ __('site.plan.position') }}" class="{{ $field }}">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3 lg:grid-cols-[1.2fr_1fr_1fr] lg:gap-4">
                                    <div class="col-span-2 lg:col-span-1">
                                        <label for="email" class="sr-only">{{ __('site.plan.email') }}</label>
                                        <input id="email" name="email" type="email" value="{{ old('email') }}" required placeholder="{{ __('site.plan.email') }}" class="{{ $field }}">
                                        @error('email')
                                            <p class="mt-2 text-b3 font-book text-orange-700">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="phone" class="sr-only">{{ __('site.plan.phone') }}</label>
                                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="{{ __('site.plan.phone') }}" class="{{ $field }}">
                                    </div>
                                    <div>
                                        <label for="country" class="sr-only">{{ __('site.plan.country') }}</label>
                                        <input id="country" name="country" type="text" value="{{ old('country') }}" placeholder="{{ __('site.plan.country') }}" class="{{ $field }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 lg:hidden">
                                <button type="button" class="btn btn-sm btn-primary w-full" @click="next()">
                                    {{ __('site.plan.next_step') }}
                                </button>
                            </div>
                        </fieldset>

                        {{-- Paso 2 --}}
                        <fieldset x-ref="step2" x-show="isDesktop || step === 2" x-cloak class="mt-10 min-w-0 lg:mt-0">
                            <legend class="w-full">
                                <span class="block text-btn3 font-book uppercase tracking-[0.04em] text-black-900 lg:hidden">
                                    {{ __('site.plan.step', ['step' => 2]) }}
                                </span>
                                <span class="mt-2 block text-s2 lg:mt-0">{{ __('site.plan.section_event') }}</span>
                            </legend>

                            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="sm:col-span-2 lg:col-span-1">
                                    <label for="event_name" class="sr-only">{{ __('site.plan.event_name') }}</label>
                                    <input id="event_name" name="event_name" type="text" value="{{ old('event_name') }}" placeholder="{{ __('site.plan.event_name') }}" class="{{ $field }}">
                                </div>
                                <div class="sm:col-span-2 lg:col-span-1">
                                    <label for="event_type" class="sr-only">{{ __('site.plan.event_type') }}</label>
                                    <select id="event_type" name="event_type" class="{{ $field }}">
                                        <option value="" @selected(old('event_type') === null || old('event_type') === '')>{{ __('site.plan.event_type') }}</option>
                                        @foreach (__('site.plan.types') as $type)
                                            <option value="{{ $type }}" @selected(old('event_type') === $type)>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                    @error('event_type')
                                        <p class="mt-2 text-b3 font-book text-orange-700">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="sm:col-span-2 lg:col-span-1">
                                    <label for="estimated_date" class="sr-only">{{ __('site.plan.estimated_date') }}</label>
                                    <input id="estimated_date" name="estimated_date" type="date" value="{{ old('estimated_date') }}" placeholder="{{ __('site.plan.estimated_date') }}" class="{{ $field }}">
                                    @error('estimated_date')
                                        <p class="mt-2 text-b3 font-book text-orange-700">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="sm:col-span-2 lg:col-span-1">
                                    <label for="attendees" class="sr-only">{{ __('site.plan.attendees') }}</label>
                                    <input id="attendees" name="attendees" type="number" inputmode="numeric" min="1" step="1" value="{{ old('attendees') }}" placeholder="{{ __('site.plan.attendees') }}" class="{{ $field }}">
                                    @error('attendees')
                                        <p class="mt-2 text-b3 font-book text-orange-700">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="origin" class="sr-only">{{ __('site.plan.origin') }}</label>
                                    <input id="origin" name="origin" type="text" value="{{ old('origin') }}" placeholder="{{ __('site.plan.origin') }}" class="{{ $field }}">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="has_venue" class="sr-only">{{ __('site.plan.has_venue') }}</label>
                                <select id="has_venue" name="has_venue" class="{{ $field }} lg:max-w-[calc(50%-0.5rem)]">
                                    <option value="" @selected(old('has_venue') === null || old('has_venue') === '')>{{ __('site.plan.has_venue') }}</option>
                                    <option value="yes" @selected(old('has_venue') === 'yes')>{{ __('site.plan.yes') }}</option>
                                    <option value="no" @selected(old('has_venue') === 'no')>{{ __('site.plan.no') }}</option>
                                </select>
                                @error('has_venue')
                                    <p class="mt-2 text-b3 font-book text-orange-700">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <label for="message" class="sr-only">{{ __('site.plan.message') }}</label>
                                <textarea id="message" name="message" rows="5" placeholder="{{ __('site.plan.message') }}" class="{{ $field }} resize-y">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-2 text-b3 font-book text-orange-700">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-8 lg:hidden">
                                <button type="button" class="btn btn-sm btn-primary w-full" @click="next()">
                                    {{ __('site.plan.next_step') }}
                                </button>
                            </div>
                        </fieldset>

                        {{-- Paso 3 --}}
                        <fieldset x-ref="step3" x-show="isDesktop || step === 3" x-cloak class="mt-10 min-w-0 lg:mt-0">
                            <legend class="w-full">
                                <span class="block text-btn3 font-book uppercase tracking-[0.04em] text-black-900 lg:hidden">
                                    {{ __('site.plan.step', ['step' => 3]) }}
                                </span>
                                <span class="mt-2 block text-s2 lg:mt-0">{{ __('site.plan.section_help') }}</span>
                            </legend>

                            <div class="mt-6 grid grid-cols-1 gap-x-10 gap-y-4 sm:grid-cols-2 lg:gap-y-3">
                                @foreach ($helpOptions as $key => $label)
                                    <label class="flex cursor-pointer items-center gap-3 text-b2 font-book text-black-900">
                                        <input
                                            type="checkbox"
                                            name="help[]"
                                            value="{{ $key }}"
                                            class="size-4 shrink-0 rounded-sm border border-black-900 accent-black-900"
                                            @checked(in_array($key, $oldHelp, true))
                                        >
                                        <span>{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-8 lg:mt-10">
                                <x-button variant="primary" type="submit" class="w-full lg:w-auto">
                                    {{ __('site.plan.submit') }}
                                </x-button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
