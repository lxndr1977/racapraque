@props([
    'title' => '',
    'description' => '',
])

<div {{ $attributes->merge(['class' => 'max-w-7xl mx-auto px-4 md:px-6 lg:px-8 mb-12']) }}>
    @if($title)
        <x-page-heading title="{{ $title }}" description="{{ $description }}" />
    @endif
    {{ $slot }}
</div>