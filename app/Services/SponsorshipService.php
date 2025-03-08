<?php

namespace App\Services;

use App\Enums\Animal\SponsorshipStatusEnum;
use App\Models\User;
use App\Models\Animal\Expense;
use App\Models\Animal\Sponsorship;
use App\Enums\User\RoleEnum;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SponsorshipService
{
    public function handleSponsorshipRequest($expense_id, $name, $email, $whatsapp)
    {
        DB::beginTransaction();

        try {
            $user = $this->getUser($email, $name, $whatsapp);

            $sponsorship = $this->checkExistingSponsorship($user, $expense_id);
            if ($sponsorship) {
                DB::rollBack();
                return [
                    'status' => 'error',
                    'message' => 'Parece que você tem um apadrinhamento aguardando o pagamento!',
                    'link' => $sponsorship->expense->payment_link
                ];
            }

            $expense = Expense::select('amount', 'payment_link')->find($expense_id);

            $this->createSponsorship($user, $expense_id, $expense->amount);

            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Solicitação de apadrinhamento enviada com sucesso!',
                'link' => $expense->payment_link
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => 'Parece que houve um erro durante o apadrinhamento!'
            ];
        }
    }

    private function getUser($email, $name, $whatsapp)
    {
        return User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'whatsapp' => $whatsapp,
                'password' => Hash::make(Str::random(12)),
                'role' => RoleEnum::Supporter,
            ]
        );
    }

    private function checkExistingSponsorship($user, $expense_id)
    {
        return Sponsorship::where('expense_id', $expense_id)
            ->where('user_id', $user->id)
            ->whereIn('status', [SponsorshipStatusEnum::Active, SponsorshipStatusEnum::Pending])
            ->first();
    }

    private function createSponsorship($user, $expense_id, $amount)
    {
        return Sponsorship::create([
            'user_id' => $user->id,
            'expense_id' => $expense_id,
            'amount' => $amount,
            'status' => SponsorshipStatusEnum::Pending,
        ]);
    }
}
