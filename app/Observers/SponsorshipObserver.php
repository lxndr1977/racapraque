<?php

namespace App\Observers;

use App\Models\Animal\Expense;
use App\Services\WhatsAppService;
use App\Models\Animal\Sponsorship;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SponsorshipActivatedMail;
use App\Mail\SponsorshipDeactivatedMail;
use App\Mail\SponsorshipConfirmationMail;
use App\Enums\Animal\SponsorshipStatusEnum;

class SponsorshipObserver
{
     public function __construct(
        private WhatsAppService $whatsAppService
    ) {}
    
    /**
     * Handle the Sponsorship "created" event.
     */
    public function created(Sponsorship $sponsorship): void
    {
        // Enviar email de confirmação quando o apadrinhamento for criado
        try {
            // Verificar se existe um email para enviar
            $email = $sponsorship->user->email ?? $sponsorship->email ?? null;
            $whatsapp = $sponsorship->user->whatsapp ?? null;

            $sponsorship->load(['expense', 'user']);
            
            if ($email) {
               Mail::to($email)->queue(new SponsorshipConfirmationMail($sponsorship));
            }

            // if ($whatsapp) {
            //    $this->sendWhatsAppNotification($sponsorship, $whatsapp);
            // }
        } catch (\Exception $e) {
            // Log do erro sem quebrar o processo
            Log::error("Erro ao enviar email de confirmação: " . $e->getMessage(), [
                'sponsorship_id' => $sponsorship->id,
                'error' => $e->getMessage()
            ]);
        }
    }


    private function sendWhatsAppNotification(Sponsorship $sponsorship, string $whatsapp): void
   {
       $animal = $sponsorship->expense->animal;
       $animalName = $animal->name ?? 'nosso amiguinho';
       $sponsorName = $sponsorship->user->firstName ?? $sponsorship->user->name ?? 'Padrinho/Madrinha';

       if ($sponsorship->status === SponsorshipStatusEnum::Active) {
           $message = "🐾💚 Olá {$sponsorName}!\n\n" .
                     "Que alegria! Seu apadrinhamento foi ATIVADO com sucesso!\n\n" .
                     "🐕 Animal: {$animalName}\n" .
                     "💰 Valor: R$ " . number_format($sponsorship->amount, 2, ',', '.') . "\n\n" .
                     "Agora {$animalName} tem um anjo da guarda! Obrigado por fazer a diferença! ❤️\n\n" .
                     "Equipe Raça Pra Quê";
       } else {
           $message = "💔 Olá {$sponsorName}!\n\n" .
                     "Notamos que seu apadrinhamento foi desativado. Queremos que saiba o quanto sua ajuda fez diferença na vida do(a) {$animalName}.\n\n" .
                     "Se quiser voltar a nos ajudar, estaremos aqui de braços abertos! 🤗\n\n" .
                     "Link para apadrinhar: {$sponsorship->expense->payment_link}\n\n" .
                     "Com gratidão,\nEquipe Raça Pra Quê";
       }

       $this->whatsAppService->sendTemplateTest($whatsapp);
   }

   /**
    * Handle the Sponsorship "updated" event.
    */
   public function updated(Sponsorship $sponsorship): void
   {
      $previousStatus = $sponsorship->getOriginal('status');
      
      // Atualiza o total da expense
      $this->updateExpenseTotalSponsorship($sponsorship->expense_id);
      
      // Envia email se o status mudou
      $this->handleStatusUpdateEmail($sponsorship, $previousStatus);
   }

   /**
    * Handle the Sponsorship "deleted" event.
    */
   public function deleted(Sponsorship $sponsorship): void
   {
      $this->updateExpenseTotalSponsorship($sponsorship->expense_id);
   }

   /**
    * Envia email quando status do sponsorship é atualizado
    */
   private function handleStatusUpdateEmail(Sponsorship $sponsorship, $previousStatus = null)
   {
       // Só envia email se o status realmente mudou
       if ($previousStatus && $previousStatus === $sponsorship->status) {
           return;
       }

       try {
           $sponsorship->load(['user', 'expense.animal']); // Carrega relacionamentos necessários
           
           $email = $sponsorship->user->email ?? $sponsorship->email ?? null;
           $whatsapp = $sponsorship->user->whatsapp ?? null;
           
           if (!$email) {
               return;
           }

           if ($sponsorship->status === SponsorshipStatusEnum::Active) {
               Mail::to($email)->queue(new SponsorshipActivatedMail($sponsorship));
           } elseif ($sponsorship->status === SponsorshipStatusEnum::Inactive) {
               Mail::to($email)->queue(new SponsorshipDeactivatedMail($sponsorship));
           }

            if ($whatsapp) {
               $this->sendWhatsAppNotification($sponsorship, $whatsapp);
           }
       } catch (\Exception $e) {
           // Log do erro mas não quebra o fluxo principal
           Log::error('Erro ao enviar email de status do sponsorship', [
               'sponsorship_id' => $sponsorship->id,
               'previous_status' => $previousStatus,
               'current_status' => $sponsorship->status,
               'error' => $e->getMessage()
           ]);
       }
   }

   /**
    * Recalcula o total de sponsorship baseado nos dados reais
    */
   private function updateExpenseTotalSponsorship(int $expenseId): void
   {
      $expense = Expense::find($expenseId);

      if (!$expense) {
         return;
      }

      // Calcula o total real baseado nos sponsorships ativos
      $totalSponsorship = Sponsorship::where('expense_id', $expenseId)
         ->where('status', SponsorshipStatusEnum::Active)
         ->sum('amount');

      $expense->total_sponsorship = $totalSponsorship;
      $expense->save();
   }

    /**
     * Handle the Sponsorship "restored" event.
     */
    public function restored(Sponsorship $sponsorship): void
    {
        //
    }

    /**
     * Handle the Sponsorship "force deleted" event.
     */
    public function forceDeleted(Sponsorship $sponsorship): void
    {
        //
    }
}