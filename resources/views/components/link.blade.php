@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'group relative font-medium text-primary']) }}>
    {{ $slot }}
    <span class="absolute -bottom-1 left-0 w-0 transition-all h-0.5 bg-primary group-hover:w-full"></span>      
</a>