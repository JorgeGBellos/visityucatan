@extends('layouts.site')

@section('title', __('site.ally_recruit.title').' — '.config('app.name'))
@section('body_class', 'bg-beige-500')

@section('footer')
    <x-site-footer :show-hero="false" background="beige" />
@endsection

@section('content')
    @php
        $fieldBase = 'mt-2 block w-full min-h-12 rounded-lg border-2 bg-beige-500 px-4 py-3 text-b2 font-book text-black-900 outline-none transition placeholder:text-black-300 focus-visible:border-black-900 focus-visible:ring-2 focus-visible:ring-black-900/20';
        $fieldOk = $fieldBase.' border-black-300 hover:border-black-900/60';
        $fieldErr = $fieldBase.' border-orange-500 focus-visible:border-orange-700 focus-visible:ring-orange-500/30';
        $label = 'text-b2 font-bold text-black-900';
        $hint = 'mt-1.5 text-b3 font-book text-black-700';
        $error = 'mt-2 text-b3 font-book text-orange-700';
        $sectionTitle = 'border-b-2 border-black-900 pb-3 text-s3 text-black-900';
        $descMax = 600;
        $descLen = mb_strlen((string) old('description', ''));
    @endphp

    <main
        class="bg-beige-500 text-black-900"
        x-data="{
            files: [],
            descMax: {{ $descMax }},
            descLen: {{ $descLen }},
            dragging: false,
            onFiles(event) {
                const list = event.target.files || event.dataTransfer?.files;
                this.files = Array.from(list || []).slice(0, 5);
            },
            onDrop(event) {
                this.dragging = false;
                const input = this.$refs.photos;
                if (!input) return;
                const dropped = event.dataTransfer?.files;
                if (!dropped?.length) return;
                const transfer = new DataTransfer();
                Array.from(dropped).slice(0, 5).forEach((file) => transfer.items.add(file));
                input.files = transfer.files;
                this.files = Array.from(input.files);
            },
            clearForm(event) {
                const form = event.target.closest('form');
                if (!form) return;
                form.reset();
                this.files = [];
                this.descLen = 0;
                this.dragging = false;
            },
            fileSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                return (bytes / 1048576).toFixed(1) + ' MB';
            }
        }"
    >
        <section class="bg-beige-500 pb-8 pt-14 lg:pb-10 lg:pt-20" aria-labelledby="ally-recruit-title">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="mx-auto max-w-2xl text-center">
                    <p class="text-btn3 font-book uppercase tracking-[0.04em] text-black-900">
                        {{ __('site.ally_recruit.eyebrow') }}
                    </p>

                    <h1 id="ally-recruit-title" class="mt-4 text-s2 lg:text-s1">
                        {{ __('site.ally_recruit.title') }}
                    </h1>

                    <p class="mt-4 text-b2 font-book text-black-700">
                        {{ __('site.ally_recruit.intro') }}
                    </p>

                    <p class="mt-3 text-b3 font-book text-black-700" id="ally-recruit-required-note">
                        {{ __('site.ally_recruit.required_note') }}
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-beige-500 pb-16 lg:pb-24" aria-label="{{ __('site.ally_recruit.title') }}">
            <div class="mx-auto max-w-site px-6 lg:px-10">
                <div class="mx-auto max-w-2xl rounded-lg border-2 border-black-900 bg-beige-100 p-6 sm:p-8 lg:p-10">
                    @if ($errors->any())
                        <div
                            class="mb-8 rounded-lg border-2 border-orange-500 bg-orange-100 px-4 py-4 text-b3 font-book text-black-900"
                            role="alert"
                            aria-live="assertive"
                            tabindex="-1"
                        >
                            <p class="font-bold">{{ __('site.ally_recruit.errors') }}</p>
                            <ul class="mt-2 list-disc space-y-1 pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('pages.allies.recruit.store') }}"
                        enctype="multipart/form-data"
                        class="space-y-10"
                        novalidate
                        aria-describedby="ally-recruit-required-note"
                    >
                        @csrf

                        <fieldset class="min-w-0 space-y-5">
                            <legend class="{{ $sectionTitle }}">
                                {{ __('site.ally_recruit.section_business') }}
                            </legend>

                            <div>
                                <label for="business_name" class="{{ $label }}">
                                    {{ __('site.ally_recruit.fields.business_name') }}
                                    <span class="text-orange-700" aria-hidden="true">*</span>
                                    <span class="sr-only">{{ __('site.ally_recruit.required_sr') }}</span>
                                </label>
                                <input
                                    id="business_name"
                                    name="business_name"
                                    type="text"
                                    value="{{ old('business_name') }}"
                                    required
                                    maxlength="160"
                                    autocomplete="organization"
                                    placeholder="{{ __('site.ally_recruit.placeholders.business_name') }}"
                                    aria-required="true"
                                    aria-invalid="{{ $errors->has('business_name') ? 'true' : 'false' }}"
                                    @if ($errors->has('business_name')) aria-describedby="business_name-error" @endif
                                    class="{{ $errors->has('business_name') ? $fieldErr : $fieldOk }}"
                                >
                                @error('business_name')
                                    <p id="business_name-error" class="{{ $error }}" role="alert">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="business_type" class="{{ $label }}">
                                    {{ __('site.ally_recruit.fields.business_type') }}
                                    <span class="text-orange-700" aria-hidden="true">*</span>
                                    <span class="sr-only">{{ __('site.ally_recruit.required_sr') }}</span>
                                </label>
                                <input
                                    id="business_type"
                                    name="business_type"
                                    type="text"
                                    value="{{ old('business_type') }}"
                                    required
                                    maxlength="120"
                                    placeholder="{{ __('site.ally_recruit.placeholders.business_type') }}"
                                    aria-required="true"
                                    aria-invalid="{{ $errors->has('business_type') ? 'true' : 'false' }}"
                                    @if ($errors->has('business_type')) aria-describedby="business_type-error" @endif
                                    class="{{ $errors->has('business_type') ? $fieldErr : $fieldOk }}"
                                >
                                @error('business_type')
                                    <p id="business_type-error" class="{{ $error }}" role="alert">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="{{ $label }}">
                                    {{ __('site.ally_recruit.fields.description') }}
                                    <span class="text-orange-700" aria-hidden="true">*</span>
                                    <span class="sr-only">{{ __('site.ally_recruit.required_sr') }}</span>
                                </label>
                                <p id="description-hint" class="{{ $hint }}">
                                    {{ __('site.ally_recruit.fields.description_hint') }}
                                </p>
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="4"
                                    required
                                    maxlength="{{ $descMax }}"
                                    placeholder="{{ __('site.ally_recruit.placeholders.description') }}"
                                    aria-required="true"
                                    aria-invalid="{{ $errors->has('description') ? 'true' : 'false' }}"
                                    aria-describedby="description-hint description-count{{ $errors->has('description') ? ' description-error' : '' }}"
                                    class="{{ ($errors->has('description') ? $fieldErr : $fieldOk) }} min-h-[120px] resize-y"
                                    @input="descLen = ($event.target.value || '').length"
                                >{{ old('description') }}</textarea>
                                <p id="description-count" class="mt-1.5 text-right text-b3 font-book text-black-500" aria-live="polite">
                                    <span x-text="`${descMax - descLen}`"></span> {{ __('site.ally_recruit.chars_remaining') }}
                                </p>
                                @error('description')
                                    <p id="description-error" class="{{ $error }}" role="alert">{{ $message }}</p>
                                @enderror
                            </div>
                        </fieldset>

                        <fieldset class="min-w-0 space-y-5">
                            <legend class="{{ $sectionTitle }}">
                                {{ __('site.ally_recruit.section_contact') }}
                            </legend>

                            <div>
                                <label for="phone" class="{{ $label }}">
                                    {{ __('site.ally_recruit.fields.phone') }}
                                    <span class="text-orange-700" aria-hidden="true">*</span>
                                    <span class="sr-only">{{ __('site.ally_recruit.required_sr') }}</span>
                                </label>
                                <input
                                    id="phone"
                                    name="phone"
                                    type="tel"
                                    value="{{ old('phone') }}"
                                    required
                                    maxlength="60"
                                    autocomplete="tel"
                                    placeholder="{{ __('site.ally_recruit.placeholders.phone') }}"
                                    aria-required="true"
                                    aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                                    @if ($errors->has('phone')) aria-describedby="phone-error" @endif
                                    class="{{ $errors->has('phone') ? $fieldErr : $fieldOk }}"
                                >
                                @error('phone')
                                    <p id="phone-error" class="{{ $error }}" role="alert">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="website" class="{{ $label }}">
                                    {{ __('site.ally_recruit.fields.website') }}
                                    <span class="text-orange-700" aria-hidden="true">*</span>
                                    <span class="sr-only">{{ __('site.ally_recruit.required_sr') }}</span>
                                </label>
                                <input
                                    id="website"
                                    name="website"
                                    type="text"
                                    value="{{ old('website') }}"
                                    required
                                    maxlength="255"
                                    inputmode="url"
                                    autocomplete="url"
                                    placeholder="{{ __('site.ally_recruit.placeholders.website') }}"
                                    aria-required="true"
                                    aria-invalid="{{ $errors->has('website') ? 'true' : 'false' }}"
                                    @if ($errors->has('website')) aria-describedby="website-error" @endif
                                    class="{{ $errors->has('website') ? $fieldErr : $fieldOk }}"
                                >
                                @error('website')
                                    <p id="website-error" class="{{ $error }}" role="alert">{{ $message }}</p>
                                @enderror
                            </div>
                        </fieldset>

                        <fieldset class="min-w-0 space-y-4">
                            <legend class="{{ $sectionTitle }}">
                                {{ __('site.ally_recruit.section_photos') }}
                            </legend>

                            <div>
                                <label for="photos" class="{{ $label }}">
                                    {{ __('site.ally_recruit.fields.photos') }}
                                    <span class="text-orange-700" aria-hidden="true">*</span>
                                    <span class="sr-only">{{ __('site.ally_recruit.required_sr') }}</span>
                                </label>
                                <p id="photos-hint" class="{{ $hint }}">
                                    {{ __('site.ally_recruit.photo_hint') }}
                                </p>
                                <ul id="photos-tips" class="mt-2 list-disc space-y-1 pl-5 text-b3 font-book text-black-700">
                                    @foreach (__('site.ally_recruit.photo_tips') as $tip)
                                        <li>{{ $tip }}</li>
                                    @endforeach
                                </ul>
                                <p id="photos-help" class="mt-2 text-b3 font-book text-black-700">
                                    {{ __('site.ally_recruit.photo_help') }}
                                </p>

                                <div
                                    class="mt-4 rounded-lg border-2 border-dashed px-4 py-8 text-center transition"
                                    :class="dragging
                                        ? 'border-black-900 bg-beige-500'
                                        : '{{ $errors->has('photos') || $errors->has('photos.*') ? 'border-orange-500 bg-orange-100/40' : 'border-black-300 bg-beige-500 hover:border-black-900' }}'"
                                    @dragover.prevent="dragging = true"
                                    @dragleave.prevent="dragging = false"
                                    @drop.prevent="onDrop($event)"
                                >
                                    <input
                                        id="photos"
                                        x-ref="photos"
                                        name="photos[]"
                                        type="file"
                                        accept="image/jpeg,image/png,image/webp"
                                        multiple
                                        required
                                        aria-required="true"
                                        aria-invalid="{{ ($errors->has('photos') || $errors->has('photos.*')) ? 'true' : 'false' }}"
                                        aria-describedby="photos-hint photos-tips photos-help photos-status{{ ($errors->has('photos') || $errors->has('photos.*')) ? ' photos-error' : '' }}"
                                        class="sr-only"
                                        @change="onFiles($event)"
                                    >

                                    <svg class="mx-auto size-10 text-black-900" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M12 16V4M12 4L8 8M12 4l4 4M4 20h16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>

                                    <p class="mt-3 text-b2 font-book text-black-900">
                                        {{ __('site.ally_recruit.photo_drop') }}
                                    </p>

                                    <label
                                        for="photos"
                                        class="btn btn-sm mt-4 inline-flex cursor-pointer border-black-900 bg-transparent text-black-900 hover:bg-black-900 hover:text-beige-100"
                                    >
                                        {{ __('site.ally_recruit.photo_add') }}
                                    </label>
                                </div>

                                <div id="photos-status" class="mt-3" aria-live="polite">
                                    <p class="text-b3 font-book text-black-700" x-show="!files.length" x-cloak>
                                        {{ __('site.ally_recruit.photo_empty') }}
                                    </p>

                                    <ul class="space-y-2" x-show="files.length" x-cloak>
                                        <li class="text-b3 font-bold text-black-900">
                                            <span x-text="files.length"></span> {{ __('site.ally_recruit.photo_selected') }}
                                        </li>
                                        <template x-for="(file, index) in files" :key="index">
                                            <li class="flex items-center justify-between gap-3 rounded-lg border border-black-300 bg-beige-300 px-3 py-2 text-b3 font-book text-black-900">
                                                <span class="min-w-0 truncate" x-text="file.name"></span>
                                                <span class="shrink-0 text-black-700" x-text="fileSize(file.size)"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>

                                @error('photos')
                                    <p id="photos-error" class="{{ $error }}" role="alert">{{ $message }}</p>
                                @enderror
                                @error('photos.*')
                                    <p id="photos-error" class="{{ $error }}" role="alert">{{ $message }}</p>
                                @enderror
                            </div>
                        </fieldset>

                        <div class="flex flex-col gap-4 border-t-2 border-black-900 pt-6 sm:flex-row sm:items-center sm:justify-between">
                            <button
                                type="submit"
                                class="btn btn-sm inline-flex min-h-12 w-full items-center justify-center border-black-900 bg-black-900 text-beige-100 hover:border-black-900 hover:bg-beige-500 hover:text-black-900 sm:w-auto"
                            >
                                {{ __('site.ally_recruit.submit') }}
                            </button>

                            <button
                                type="button"
                                class="inline-flex min-h-12 items-center justify-center text-b2 font-book text-black-700 underline-offset-4 transition hover:text-black-900 hover:underline"
                                @click="clearForm($event)"
                            >
                                {{ __('site.ally_recruit.reset') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
