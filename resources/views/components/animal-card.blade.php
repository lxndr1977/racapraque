@props([
    'action',
    'slug',
    'name',
    'gender',
    'image',
    'listStyle' => 'grid',
    'location',
    'specie' => ''
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
   
   @case('view')
        @php
            $route = 'animal.show';
            $label = 'Detalhes';
        @endphp 
        @break
@endswitch

@php
   $classesCard = $listStyle == \App\Enums\Animal\ListStyleEnum::Grid->value 
      ? 'flex flex-col'
      : 'flex flex-row gap-4 items-center';

   $classesImage = $listStyle == \App\Enums\Animal\ListStyleEnum::Grid->value 
      ? 'w-full mb-4'
      : 'w-full max-h-18 md:max-h-20';
@endphp

<div class="bg-white border border-zinc-100 rounded-lg p-4 shadow-sm transition transition-duration-3 hover:-translate-y-2 hover:cursor-pointer">
   <article>
        <a href="{{ route($route, $slug) }}" class="{{ $classesCard }}">
            <div>
               <img
                  src="{{ asset('images/animal-placeholder-300px.webp') }}" 
                  data-src="{{ $image }}"    
                  alt="{{ $name }}" 
                  loading="lazy"
                  width="300"
                  height="300" 
                  class="lazyload rounded-md aspect-square h-auto {{ $classesImage }}">                   
            </div>
                  
            <div>
               <h3 class="text-lg font-medium line-clamp-1">{{ $name }}</h3>
               
               <p class="text-sm text-gray-600">Espécie: {{ $specie }}</p>

               @if(($action == 'view')) 
                  <p class="text-sm text-gray-600">Local: {{ $location }}</p>
               @endif

               @if(($action != 'view')) 
                  <x-button type="link" hef="{{ route($route, $slug) }}" class="w-full  mt-6">
                     {{ $label }}
                  </x-button>
               @endif
            </div>
        </a>
    </article>
</div>