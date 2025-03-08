
@props([
    'type' => 'button',
    'href' => '',
    'size' => 'default',
    'variant' => 'primary'    
])

@php
    $baseClasses = "inline-block font-medium text-center rounded-lg transition duration-200 hover:cursor-pointer";

    $sizeClasses = match ($size) {
        'default' => 'px-4 py-2 text-base',
        'medium' => 'px-5 py-2.5 text-md',
        'large' => 'px-6 py-3 text-lg',
    };

    $variantClasses = match ($variant) {
        'primary' => 'bg-primary text-white hover:bg-primary-hover',
        'secondary' => 'border-2 border-fuchsia-600 text-fuchsia-600 hover:bg-fuchsia-600 hover:text-white',
    };

    $classes = "$baseClasses $sizeClasses $variantClasses";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}">
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}"">
        {{ $slot }}
    </button>
@endif
