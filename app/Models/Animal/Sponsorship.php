<?php

namespace App\Models\Animal;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Animal\SponsorshipStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sponsorship extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expense_id',
        'amount',
        'status',
        'notes'
    ];

    protected $casts = [
        'status' => SponsorshipStatusEnum::class
    ];

    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function animal()
    {
        return $this->hasManyThrough(
            Animal::class,              // Modelo
            Expense::class,             // Tabela intermediária
            'id',                       // Chave estrangeira da tabela intermediária (Expense)
            'id',                       // Chave primária da tabela final (Animal)
            'expense_id',               // Chave da tabela de origem (Sponsorship) que se relaciona com Expense
            'animal_id'                 // Chave na tabela intermediária (Expense) que se relaciona com Animal
        );
    }
}
