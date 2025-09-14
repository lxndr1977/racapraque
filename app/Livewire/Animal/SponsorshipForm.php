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

           public  $showReminder = true;
           public $reminderData = [];


    public array $expenseOptions = [];

    public $totalExpenses = 0;
    public $totalSponsored = 0;
    public $progressPercentage = 0;
    public $remainingAmount = 0;

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
         $this->expenseOptions = $this->expenses->pluck('id')->toArray();

         $this->calculateTotals();

                 $this->showReminder = false;
         $this->reminderData = [
             'type' => null,
             'text' => null,  
             'link' => null,
         ];
    }

    private function calculateTotals()
    {
        $this->totalExpenses = $this->expenses->sum('amount');
        $this->totalSponsored = $this->expenses->sum('total_sponsorship');
        $this->remainingAmount = $this->totalExpenses - $this->totalSponsored;
        $this->progressPercentage = $this->totalExpenses > 0 
            ? round(($this->totalSponsored / $this->totalExpenses) * 100, 1)
            : 0;
    }

    // Método para limpar o modal e a sessão
    public function closeModal()
    {
        // Remove a mensagem flash da sessão
        session()->forget('message');
        
        // Limpa os erros de validação (caso existam)
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function getFormattedTotalExpenses()
    {
        return 'R$ ' . number_format($this->totalExpenses, 2, ',', '.');
    }

    public function getFormattedTotalSponsored()
    {
        return 'R$ ' . number_format($this->totalSponsored, 2, ',', '.');
    }

    public function getFormattedRemainingAmount()
    {
        return 'R$ ' . number_format($this->remainingAmount, 2, ',', '.');
    }

    public function getIsFullySponsored()
    {
        return $this->totalSponsored >= $this->totalExpenses;
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

        if ($result['status'] === 'success') {
            $this->reset(['name', 'email', 'whatsapp']);
            // Salva diretamente no lembrete para casos de sucesso
            $this->showReminder = true;
            $this->reminderData = [
                'type' => $result['status'],
                'text' => $result['message'],
                'link' => $result['link'] ?? null,
            ];
        }

        session()->flash('message', [
            'type' => $result['status'],
            'text' => $result['message'],
            'link' => $result['link'] ?? null,
        ]);
    }
}