<?php

namespace App\Livewire\Animal;

use App\Enums\Animal\ListStyleEnum;
use App\Enums\Animal\ScopeEnum;
use App\Enums\Animal\SpecieEnum;
use App\Enums\Animal\GenderEnum;
use App\Models\Animal\Location;
use Livewire\Component;
use App\Models\Animal\Animal;
use Livewire\WithPagination;

class AnimalList extends Component
{
    use WithPagination;

    public $scope;
    public $listStyle = ListStyleEnum::Grid->value;
    
    // Controle de filtros
    public $showFilters = false;
    public $availableFilters = [];
    public $filtersExpanded = false;
    
    // Filtros
    public $filterSpecie = '';
    public $filterGender = '';
    public $filterLocation = '';
    public $filterIsVolunteer = '';
    
    // Para resetar paginação quando filtros mudarem
    protected $updatesQueryString = [
        'filterSpecie' => ['except' => ''],
        'filterGender' => ['except' => ''],
        'filterLocation' => ['except' => ''],
        'filterIsVolunteer' => ['except' => ''],
    ];

    public function mount($scope = 'all', $listStyle = null, $showFilters = false, $availableFilters = [])
    {
        $this->scope = $scope;
        $this->listStyle = $listStyle ?? ListStyleEnum::Grid->value;
        $this->showFilters = $showFilters;
        $this->availableFilters = $availableFilters;
    }

    public function toggleFilters()
    {
        $this->filtersExpanded = !$this->filtersExpanded;
    }

    public function hasFilter($filterName)
    {
        return empty($this->availableFilters) || in_array($filterName, $this->availableFilters);
    }

    public function updatedFilterSpecie()
    {
        $this->resetPage();
    }

    public function updatedFilterGender()
    {
        $this->resetPage();
    }

    public function updatedFilterLocation()
    {
        $this->resetPage();
    }

    public function updatedFilterIsVolunteer()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->filterSpecie = '';
        $this->filterGender = '';
        $this->filterLocation = '';
        $this->filterIsVolunteer = '';
        $this->resetPage();
    }

    public function render()
    {
        $animals = Animal::query();
        
        $animals->select('id', 'name', 'specie', 'gender', 'slug', 'location_id')            
            ->with('location'); // Sempre carregar location para evitar N+1

        // Aplicar scopes
        if ($this->scope === ScopeEnum::Actives) {
            $animals->actives();
        } 

        if ($this->scope === ScopeEnum::Visibles) {
            $animals->visiblesOnSite();
        } 

        if ($this->scope === ScopeEnum::Adoptables) {
            $animals->adoptables();
        } 
        
        if ($this->scope === ScopeEnum::Sponsorables) {
            $animals->sponsorables();
        }

        // Aplicar filtros apenas se filtros estão habilitados
        if ($this->showFilters) {
            if ($this->filterSpecie && $this->hasFilter('specie')) {
                $animals->where('specie', $this->filterSpecie);
            }

            if ($this->filterGender && $this->hasFilter('gender')) {
                $animals->where('gender', $this->filterGender);
            }

            if ($this->filterLocation && $this->hasFilter('location')) {
                $animals->where('location_id', $this->filterLocation);
            }

            if ($this->filterIsVolunteer !== '' && $this->hasFilter('volunteer')) {
                $isVolunteer = $this->filterIsVolunteer === '1';
                $animals->whereHas('location', function ($query) use ($isVolunteer) {
                    $query->where('is_volunteer', $isVolunteer);
                });
            }
        }

       $totalAnimals = $animals->count();

        
        $animals = $animals->orderBy('name')->simplePaginate(24);

        // Dados para os selects dos filtros (apenas se filtros estão habilitados)
        $species = $genders = $locations = collect();
        
        if ($this->showFilters) {
            if ($this->hasFilter('specie')) {
                $species = collect(SpecieEnum::cases())->map(function ($specie) {
                    return [
                        'value' => $specie->value,
                        'label' => $specie->getLabel()
                    ];
                });
            }

            if ($this->hasFilter('gender')) {
                $genders = collect(GenderEnum::cases())->map(function ($gender) {
                    return [
                        'value' => $gender->value,
                        'label' => $gender->getLabel()
                    ];
                });
            }

            if ($this->hasFilter('location') || $this->hasFilter('volunteer')) {
                $locations = Location::select('id', 'name')
                    ->orderBy('name')
                    ->get()
                    ->map(function ($location) {
                        return [
                            'value' => $location->id,
                            'label' => $location->name
                        ];
                    });
            }
        }

        return view('livewire.animal.animal-list', [
            'animals' => $animals,
            'species' => $species,
            'genders' => $genders,
            'locations' => $locations,
            'totalAnimals' => $totalAnimals
        ]);
    }
}