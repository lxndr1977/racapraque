<?php

namespace App\Enums\User;

use Filament\Support\Contracts\HasLabel;

enum RoleEnum: string implements HasLabel
{
    case Admin = 'admin';
    case User = 'user';
    case Supporter = 'supporter';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::User => 'Usuário',
            self::Supporter => 'Apoiador',
        };
    }
   
}