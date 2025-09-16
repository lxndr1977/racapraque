<?php

namespace App\Livewire\Animal;

use Livewire\Component;
use App\Models\Animal\Animal;
use Illuminate\Support\Collection;
use App\Services\SponsorshipService;

class SponsorshipForm extends Component
{
   public Animal $animal;
   public Collection $expenses;

   public $expense_id;
   public $name;
   public $email;
   public $whatsapp;
   public $consent = true;

   public $showReminder = false;
   public $reminderData = [];

   public array $expenseOptions = [];

   public $totalExpenses = 0;
   public $totalSponsored = 0;
   public $progressPercentage = 0;
   public $remainingAmount = 0;

   // Controle do modal
   public $isModalOpen = false;
   public $modalData = [];

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

      // Inicializa o estado do modal
      $this->showReminder = false;
      $this->reminderData = [
         'type' => null,
         'text' => null,
         'link' => null,
      ];

      $this->isModalOpen = false;
      $this->modalData = [];
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

   /**
    * Fecha o modal e limpa todas as mensagens
    */
   public function closeModal()
   {
      $this->isModalOpen = false;
      $this->modalData = [];

      // Limpa erros de validação
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

         // Para sucesso, usa o reminder interno
         $this->showReminder = true;
         $this->reminderData = [
            'type' => $result['status'],
            'text' => $result['message'],
            'link' => $result['link'] ?? null,
         ];
      } else {
         // Para erro, usa flash session (opcional, ou pode usar reminder também)
         session()->flash('message', [
            'type' => $result['status'],
            'text' => $result['message'],
            'link' => $result['link'] ?? null,
         ]);
      }

      // Abre o modal com o resultado
      $this->openModal(
         $result['status'],
         $result['message'],
         $result['link'] ?? null
      );
   }

   public function openModal($type, $message, $link = null)
   {
      $this->modalData = [
         'type' => $type,
         'message' => $message,
         'link' => $link,
      ];
      $this->isModalOpen = true;
   }
}
