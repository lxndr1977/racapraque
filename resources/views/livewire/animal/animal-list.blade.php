<div>
    @if ($animals->isNotEmpty())
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($animals as $animal)
            <x-animal-card 
                    action="{{ $scope === \App\Enums\Animal\ScopeEnum::Adoptables ? 'adoption' : 'sponsorship' }}"
                    image="{{ $animal->getFirstMediaUrl('animals', 'responsive') ?: asset('images/animal-placeholder.jpg') }}"
                    slug="{{ $animal->slug }}"
                    name="{{ $animal->name }}"
                    gender="{{ $animal->genderLabel }}"/>
            @endforeach
        </div>

        <div class="py-8">
            {{ $animals->links() }}
        </div>
    @else
        <p class="text-center text-zinc-500">Ops! Nenhum animal encontrado.</p>
    @endif
</div>
