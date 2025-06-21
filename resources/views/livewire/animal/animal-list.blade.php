<div>
    @if ($animals->isNotEmpty())
        @if ($listStyle == App\Enums\Animal\ListStyleEnum::Grid->value)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @endif
            @foreach ($animals as $animal)
               <x-animal-card 
                  action="{{ match($scope) {
                     \App\Enums\Animal\ScopeEnum::Adoptables => 'adoption',
                     \App\Enums\Animal\ScopeEnum::Sponsorables => 'sponsorship',
                     \App\Enums\Animal\ScopeEnum::Actives => 'view',
                     default => 'view',
                  } }}"
                  image="{{ $animal->getFirstMediaUrl('animals', 'responsive') ?? asset('images/animal-placeholder-300px.webp') }}"
                  slug="{{ $animal->slug }}"
                  name="{{ $animal->name }}"
                  gender="{{ $animal->genderLabel }}"
                  location="{{ $animal->locationName }}"
                  listStyle="{{ $listStyle }}"
                  specie="{{ $animal->specieLabel }}"
               />
            @endforeach
        </div>

        <div class="py-8">
            {{ $animals->links() }}
        </div>
    @else
        <p class="text-center text-zinc-500">Ops! Nenhum animal encontrado.</p>
    @endif
</div>
