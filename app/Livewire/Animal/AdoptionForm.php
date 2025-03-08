<?php

namespace App\Livewire\Animal;

use Livewire\Component;
use App\Models\Animal\AdoptionRequest;

class AdoptionForm extends Component
{
    public $animal_id;
    public $animal_name;
    public $name;
    public $email;
    public $phone;
    public $whatsapp;
    public $consent = true;

    protected $rules = [
        'animal_id' => 'required|exists:animals,id',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'whatsapp' => 'required|string|max:20',
        'consent' => 'accepted',
    ];

    public function mount($animal_id = null)
    {
        $this->animal_id = $animal_id;
    }

    public function render()
    {
        return view('livewire.animal.adoption-form');
    }
    
    public function submit()
    {
        $this->validate();

        try {

            AdoptionRequest::create([
                'animal_id' => $this->animal_id, 
                'name' => $this->name,
                'email' => $this->email,
                'whatsapp' => $this->whatsapp,
            ]);
    
            session()->flash('message', [
                'type' => 'success',
                'text' => 'A solicitação da adoção foi enviada com sucesso!'
            ]);

            $this->reset(['name', 'email', 'phone', 'whatsapp']);
        } catch (\Exception $e) {
            session()->flash('message', [
                'type' => 'error',
                'text' => 'Parece que houve um erro durante a solicitação da adoção!'
            ]);
        }
    }
}
