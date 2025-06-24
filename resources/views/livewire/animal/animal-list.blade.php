@props(['listStyle' => 'grid'])
<div>
    {{-- Seção de Filtros - Apenas se habilitada --}}
    @if($showFilters)
        <div class="bg-white rounded-lg shadow-sm border mb-6 overflow-hidden">
            {{-- Cabeçalho dos filtros - Mobile --}}
            <div class="lg:hidden bg-gray-50 px-4 py-3 border-b">
                <button wire:click="toggleFilters" 
                        class="flex items-center justify-between w-full text-left">
                    <span class="text-sm font-medium text-gray-900">
                        Filtros
                        @if($filterSpecie || $filterGender || $filterLocation || $filterIsVolunteer !== '')
                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ collect([$filterSpecie, $filterGender, $filterLocation, $filterIsVolunteer !== '' ? 'volunteer' : null])->filter()->count() }}
                            </span>
                        @endif
                    </span>
                    <svg class="w-5 h-5 text-gray-400 transform transition-transform {{ $filtersExpanded ? 'rotate-180' : '' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>

            {{-- Conteúdo dos filtros --}}
            <div class="p-4 {{ $filtersExpanded ? 'block' : 'hidden' }} lg:block">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    {{-- Filtro por Espécie --}}
                    @if($this->hasFilter('specie'))
                        <div>
                            <label for="filter-specie" class="block text-sm font-medium text-gray-700 mb-2">
                                Espécie
                            </label>
                            <div class="relative">
                                <select wire:model.live="filterSpecie" id="filter-specie" 
                                        class="w-full pl-3 pr-10 py-2.5 text-sm border border-gray-300 rounded-lg bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-20 focus:outline-none transition-all duration-200 appearance-none">
                                    <option value="">Todas as espécies</option>
                                    @foreach($species as $specie)
                                        <option value="{{ $specie['value'] }}">{{ $specie['label'] }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Filtro por Gênero --}}
                    @if($this->hasFilter('gender'))
                        <div>
                            <label for="filter-gender" class="block text-sm font-medium text-gray-700 mb-2">
                                Gênero
                            </label>
                            <div class="relative">
                                <select wire:model.live="filterGender" id="filter-gender"
                                        class="w-full pl-3 pr-10 py-2.5 text-sm border border-gray-300 rounded-lg bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-20 focus:outline-none transition-all duration-200 appearance-none">
                                    <option value="">Todos os gêneros</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender['value'] }}">{{ $gender['label'] }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Filtro por Localização --}}
                    @if($this->hasFilter('location'))
                        <div>
                            <label for="filter-location" class="block text-sm font-medium text-gray-700 mb-2">
                                Local
                            </label>
                            <div class="relative">
                                <select wire:model.live="filterLocation" id="filter-location"
                                        class="w-full pl-3 pr-10 py-2.5 text-sm border border-gray-300 rounded-lg bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-20 focus:outline-none transition-all duration-200 appearance-none">
                                    <option value="">Todas as localizações</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location['value'] }}">{{ $location['label'] }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Filtro por Voluntário --}}
                    @if($this->hasFilter('volunteer'))
                        <div>
                            <label for="filter-volunteer" class="block text-sm font-medium text-gray-700 mb-2">
                                Tipo de Local
                            </label>
                            <div class="relative">
                                <select wire:model.live="filterIsVolunteer" id="filter-volunteer"
                                        class="w-full pl-3 pr-10 py-2.5 text-sm border border-gray-300 rounded-lg bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-20 focus:outline-none transition-all duration-200 appearance-none">
                                    <option value="">Todos</option>
                                    <option value="1">Voluntário</option>
                                    <option value="0">Pago</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Botão Limpar Filtros --}}
                    <div class="flex items-end">
                        <button wire:click="clearFilters" 
                                class="w-full px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-20">
                            Limpar Filtros
                        </button>
                    </div>
                </div>

                {{-- Indicador de filtros ativos --}}
                @if($filterSpecie || $filterGender || $filterLocation || $filterIsVolunteer !== '')
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <div class="flex flex-wrap gap-2 items-center">
                            <span class="text-sm text-gray-600">Filtros ativos:</span>
                            
                            @if($filterSpecie && $this->hasFilter('specie'))
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-zinc-100 text-zinc-800 rounded-full">
                                    Espécie: {{ collect($species)->firstWhere('value', $filterSpecie)['label'] ?? $filterSpecie }}
                                </span>
                            @endif
                            
                            @if($filterGender && $this->hasFilter('gender'))
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-zinc-100 text-zinc-800 rounded-full">
                                    Gênero: {{ collect($genders)->firstWhere('value', $filterGender)['label'] ?? $filterGender }}
                                </span>
                            @endif
                            
                            @if($filterLocation && $this->hasFilter('location'))
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-zinc-100 text-zinc-800 rounded-full">
                                    Local: {{ collect($locations)->firstWhere('value', $filterLocation)['label'] ?? $filterLocation }}
                                </span>
                            @endif
                            
                            @if($filterIsVolunteer !== '' && $this->hasFilter('volunteer'))
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-zinc-100 text-zinc-800 rounded-full">
                                    Lar Temporário: {{ $filterIsVolunteer === '1' ? 'Sim' : 'Não' }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
                 
            </div>
        </div>
       <div class="mb-6 font-bold text-sm text-primary">
         {{ trans_choice('{0} Nenhum animal encontrado|{1} :count animal encontrado|[2,*] :count animais encontrados', $animals->count(), ['count' => $animals->count()]) }}
      </div>
    @endif

    {{-- Lista de Animais --}}
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
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum animal encontrado</h3>
                @if($filterSpecie || $filterGender || $filterLocation || $filterIsVolunteer !== '')
                    <p class="mt-1 text-sm text-gray-500">
                        Não encontramos animais com os filtros selecionados. Tente ajustar os critérios de busca.
                    </p>
                    <div class="mt-6">
                        <button wire:click="clearFilters" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Limpar todos os filtros
                        </button>
                    </div>
                @else
                    <p class="mt-1 text-sm text-gray-500">
                        Ops! Nenhum animal encontrado nesta categoria.
                    </p>
                @endif
            </div>
        </div>
    @endif
</div>