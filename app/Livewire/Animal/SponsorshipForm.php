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

    // ===== APENAS ADIÇÕES - NÃO MEXE NO SEU CÓDIGO ORIGINAL =====
    public $totalExpenses = 0;
    public $totalSponsored = 0;
    public $progressPercentage = 0;
    public $remainingAmount = 0;
    // ============================================================

    protected $rules = [
        'expense_id' => 'required|exists:expenses,id',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'whatsapp' => 'required|string|max:20',
        'consent' => 'accepted',
    ];

    public function mount(Animal $animal, Collection $expenses)
    {
         // SEU CÓDIGO ORIGINAL - NÃO MEXO NADA AQUI
         $this->animal = $animal;
         $firstExpense = $animal->expensesActive->firstWhere('status', \App\Enums\Animal\ExpenseStatusEnum::Active);
         $this->expense_id = $firstExpense ? $firstExpense->id : null;
         $this->expenses = $expenses;
         $this->expenseOptions = $this->expenses->pluck('id')->toArray();

         // APENAS ESTA LINHA ADICIONADA
         $this->calculateTotals();
    }

    // ===== MÉTODOS NOVOS - NÃO AFETAM SEU CÓDIGO =====
    private function calculateTotals()
    {
        $this->totalExpenses = $this->expenses->sum('amount');
        $this->totalSponsored = $this->expenses->sum('total_sponsorship');
        $this->remainingAmount = $this->totalExpenses - $this->totalSponsored;
        $this->progressPercentage = $this->totalExpenses > 0 
            ? round(($this->totalSponsored / $this->totalExpenses) * 100, 1)
            : 0;
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
    // ================================================

    public function render()
    {
        return view('livewire.animal.sponsorship-form', ['animal' => $this->animal]);
    }

    public function submit(SponsorshipService $sponsorshipService)
    {
        // SEU CÓDIGO ORIGINAL - ZERO ALTERAÇÕES
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
            
            // OPCIONAL: Se quiser atualizar os totais após novo patrocínio
            // Descomente as linhas abaixo se precisar
            // $this->expenses = $this->animal->expensesActive;
            // $this->calculateTotals();
        }
    }
}