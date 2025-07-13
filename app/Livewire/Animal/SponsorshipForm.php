<?php

namespace App\Livewire\Animal;

use Livewire\Component;
use App\Models\Animal\Animal;
use Illuminate\Support\Collection;
use App\Services\SponsorshipService;
use Psy\TabCompletion\Matcher\FunctionsMatcher;


class SponsorshipForm extends Component
{
    public Animal $animal;
    public Collection $expenses;

    public $expense_id;
    public $name;
    public $email;
    public $whatsapp;
    public $consent = true;

    public array $expenseOptions = [];

    protected $rules = [
        'expense_id' => 'required|exists:expenses,id',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'whatsapp' => 'required|string|max:20',
        'consent' => 'accepted',
    ];

    public function mount(Animal $animal, Collection $expenses)
    {
         $this->animal = $animal;
         $firstExpense = $animal->expensesActive->firstWhere('status', \App\Enums\Animal\ExpenseStatusEnum::Active);
         $this->expense_id = $firstExpense ? $firstExpense->id : null;
         $this->expenses = $expenses;
;
         $this->expenseOptions = $this->expenses->pluck('id')->toArray();
    }

    public function render()
    {
        return view('livewire.animal.sponsorship-form', ['animal' => $this->animal]);
    }

    public function submit(SponsorshipService $sponsorshipService)
    {
        $this->validate();

        $result = $sponsorshipService->handleSponsorshipRequest(
            $this->expense_id,
            $this->name,
            $this->email,
            $this->whatsapp
        );

        session()->flash('message', [
            'type' => $result['status'],
            'text' => $result['message'],
            'link' => $result['link'] ?? null,
        ]);

        if ($result['status'] === 'success') {
            // $this->dispatch('animalSponsored', $result['link']);
            $this->reset(['name', 'email', 'whatsapp']);
        }
    }
}
