<?php

namespace App\Livewire\Animal;

use App\Enums\Animal\ListStyleEnum;
use App\Enums\Animal\ScopeEnum; 
use Livewire\Component;
use App\Models\Animal\Animal;

class AnimalList extends Component
{
    public $scope;

    public $listStyle = ListStyleEnum::Grid->value;

    public function mount($scope = 'all')
    {
        $this->scope = $scope;
    }

    public function render()
    {
        $animals = Animal::query();
        
        $animals->select('id', 'name', 'specie', 'gender', 'slug', 'location_id')            
            ->with('location'); // Sempre carregar location para evitar N+1

        if ($this->scope === ScopeEnum::Actives) {
            $animals->actives();
        } 

        if ($this->scope === ScopeEnum::Adoptables) {
            $animals->adoptables();
        } 
        
        if ($this->scope === ScopeEnum::Sponsorables) {
            $animals->sponsorables();
        }
        
        $animals = $animals->orderBy('name')->simplePaginate(24);

        return view('livewire.animal.animal-list', ['animals' => $animals]);
    }
}
