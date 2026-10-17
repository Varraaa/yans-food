@props([
    'variant' => 'primary',
    'href' => null,
    'type' => 'button',
    'icon' => null,
    'arrow' => false,
    'loading' => false,
])

@php
    $baseClass = match($variant) {
        'outline' => 'btn-outline',
        'whatsapp' => 'btn-whatsapp',
        'ghost' => 'btn-ghost',
        default => 'btn-primary',
    };

    if ($loading) {
        $baseClass .= ' btn-loading';
    }
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClass . ' press-scale text-sm']) }}>
        @if($icon)
            <span class="material-symbols-outlined text-[18px] sm:text-[20px]">{{ $icon }}</span>
        @endif

        <span>{{ $slot }}</span>

        @if($arrow)
            <span class="btn-arrow font-bold text-sm" aria-hidden="true">→</span>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $baseClass . ' press-scale text-sm', 'disabled' => $loading]) }}>
        @if($loading)
            <span class="btn-spinner mr-2" aria-hidden="true"></span>
            <span>Memproses…</span>
        @else
            @if($icon)
                <span class="material-symbols-outlined text-[18px] sm:text-[20px]">{{ $icon }}</span>
            @endif

            <span>{{ $slot }}</span>

            @if($arrow)
                <span class="btn-arrow font-bold text-sm" aria-hidden="true">→</span>
            @endif
        @endif
    </button>
@endif
