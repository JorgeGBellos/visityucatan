@props([
    'variant' => 'primary',
    'size' => 'sm',
    'arrow' => null,
    'href' => null,
    'type' => 'button',
])

@php
    $variants = [
        'primary' => 'btn-primary',
        'green' => 'btn-green',
        'secondary' => 'btn-secondary',
        'tertiary' => 'btn-tertiary',
        'auxiliar' => 'btn-auxiliar',
        'auxiliar-green' => 'btn-auxiliar-green',
    ];

    $sizes = [
        'sm' => 'btn-sm',
        'md' => null,
        'lg' => 'btn-lg',
    ];

    $variantClass = $variants[$variant] ?? $variants['primary'];
    $sizeClass = $sizes[$size] ?? null;
    $tag = $href ? 'a' : 'button';
@endphp

<{{ $tag }}
    @if ($href) href="{{ $href }}" @else type="{{ $type }}" @endif
    {{ $attributes->class(['btn', $variantClass, $sizeClass]) }}
>
    @if ($arrow === 'left')
        <svg class="btn-icon" viewBox="0 0 18 12" fill="none" aria-hidden="true">
            <path d="M17 6H1M1 6L6.5 1M1 6L6.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    @endif

    <span>{{ $slot }}</span>

    @if ($arrow === 'right')
        <svg class="btn-icon" viewBox="0 0 18 12" fill="none" aria-hidden="true">
            <path d="M1 6H17M17 6L11.5 1M17 6L11.5 11" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    @endif
</{{ $tag }}>
