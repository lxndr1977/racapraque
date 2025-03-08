@props([
    'action',
    'slug',
    'name',
    'gender',
    'image',
])

@switch($action)
    @case('adoption')
        @php
            $route = 'adoption.create'; 
            $label = 'Adote';
        @endphp 
        @break
    
    @case('sponsorship')
        @php
            $route = 'sponsorship.create';
            $label = 'Apadrinhe';
        @endphp 
        @break
@endswitch

<div class="bg-white border border-zinc-100 rounded-lg p-4 shadow-sm transition transition-duration-3 hover:-translate-y-2 hover:cursor-pointer">
    <article>
       
        <a href="{{ route($route, $slug) }}">
            <img 
                src="{{ $image }}"    
                alt="{{ $name }}" 
                loading="lazy" 
                class="mb-4 rounded-md">                        
            <h3 class="text-lg font-medium line-clamp-1">{{ $name }}</h3>
            <p class="text-sm text-gray-600 mb-6">{{ $gender }}</p>

            <x-button type="link" hef="{{ route($route, $slug) }}" class="w-full">
                {{ $label }}
            </x-button>
        </a>
    </article>
</div>