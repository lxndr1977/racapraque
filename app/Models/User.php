<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\User\RoleEnum;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'whatsapp',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => RoleEnum::class,
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    protected function firstName(): Attribute
    {
        return Attribute::get(fn () => explode(' ', $this->name)[0]);
    }

     protected function whatsapp(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? $this->formatPhone($value) : $value,
            set: fn ($value) => preg_replace('/\D/', '', $value), // Remove tudo que não é dígito
        );
    }

    // Método helper para formatar telefone
    private function formatPhone($value)
    {
        $cleaned = preg_replace('/\D/', '', $value);
        
        if (strlen($cleaned) <= 10) {
            // Telefone fixo: (11) 9999-9999
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $cleaned);
        } else {
            // Celular: (11) 99999-9999
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $cleaned);
        }
    }
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === RoleEnum::Admin;
    }
}
