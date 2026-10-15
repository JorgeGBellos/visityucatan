<li
    class="overflow-hidden rounded-lg bg-yellow-100"
    :class="{
        'grid grid-cols-1 sm:grid-cols-2': view === 'columns',
        'relative': view === 'list'
    }"
>
    {{-- Image: top in cards, left in columns, hidden in list --}}
    <div
        x-show="view !== 'list'"
        class="w-full overflow-hidden"
        :class="{
            'aspect-[355/226]': view === 'cards',
            'aspect-[355/226] h-full sm:aspect-auto sm:min-h-full': view === 'columns',
            'bg-beige-100': item.imageMode === 'contain'
        }"
    >
        <img
            :src="item.image"
            :alt="item.name"
            class="h-full w-full"
            :class="item.imageMode === 'contain' ? 'object-contain p-6' : 'object-cover'"
        >
    </div>

    <div
        class="relative flex flex-col"
        :class="{
            'p-4': view === 'cards',
            'p-5 pr-14': view === 'columns',
            'p-5 pr-16': view === 'list'
        }"
    >
        {{-- Arrow: bottom-right with last meta in cards; top-right in columns; middle-right in list --}}
        <a
            x-show="view !== 'cards'"
            :href="item.href"
            class="absolute inline-flex size-10 items-center justify-center rounded-full bg-beige-100 text-black-900 transition hover:bg-black-900 hover:text-beige-100"
            :class="view === 'columns' ? 'right-4 top-4' : 'right-4 top-1/2 -translate-y-1/2'"
            :aria-label="'{{ $visitLabel }} ' + item.name"
        >
            <svg class="size-4" viewBox="0 0 18 12" fill="none" aria-hidden="true">
                <path d="M1 6H17M17 6L11.5 1M17 6L11.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>

        <p class="text-btn3 font-book uppercase tracking-[0.04em] text-black-900" x-text="item.label"></p>
        <h2 class="mt-2 text-b1 font-bold text-black-900" x-text="item.name"></h2>
        <p
            class="mt-2 hidden text-b2 font-book text-black-900 lg:block"
            x-show="item.description"
            x-text="item.description"
        ></p>

        <ul
            class="mt-2 text-b2 font-book text-black-900"
            :class="{
                'space-y-2': view === 'cards' || view === 'columns',
                'mt-6 flex flex-wrap items-center gap-x-6 gap-y-2': view === 'list'
            }"
        >
            <li class="flex items-center gap-2">
                <img
                    src="{{ asset('images/svg/world.svg') }}"
                    alt=""
                    class="shrink-0"
                    :class="view === 'cards' ? 'size-5 lg:size-6' : 'size-4'"
                    :width="view === 'cards' ? 24 : 16"
                    :height="view === 'cards' ? 24 : 16"
                    aria-hidden="true"
                >
                <span x-text="item.phone"></span>
            </li>
            <li class="flex items-center gap-2">
                <img
                    src="{{ asset('images/svg/world.svg') }}"
                    alt=""
                    class="shrink-0"
                    :class="view === 'cards' ? 'size-5 lg:size-6' : 'size-4'"
                    :width="view === 'cards' ? 24 : 16"
                    :height="view === 'cards' ? 24 : 16"
                    aria-hidden="true"
                >
                <span x-text="item.website"></span>
            </li>
            <li class="flex items-center gap-2">
                <img
                    src="{{ asset('images/svg/world.svg') }}"
                    alt=""
                    class="shrink-0"
                    :class="view === 'cards' ? 'size-5 lg:size-6' : 'size-4'"
                    :width="view === 'cards' ? 24 : 16"
                    :height="view === 'cards' ? 24 : 16"
                    aria-hidden="true"
                >
                <span class="min-w-0 flex-1" x-text="item.location"></span>
                <a
                    x-show="view === 'cards'"
                    :href="item.href"
                    class="ml-auto inline-flex size-10 shrink-0 items-center justify-center rounded-full bg-beige-100 text-black-900 transition hover:bg-black-900 hover:text-beige-100"
                    :aria-label="'{{ $visitLabel }} ' + item.name"
                >
                    <svg class="size-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M4 12L12 4M12 4H6.5M12 4V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </li>
        </ul>
    </div>
</li>
