<?php

namespace App\Enums\Animal;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusEnum: string implements HasLabel, HasColor, HasIcon
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Adopted = 'adopted';
    case Dead = 'dead';

    public function getLabel(): string
    {
        return match ($this) {
            self::Active => 'Ativo',
            self::Inactive => 'Inativo',
            self::Adopted => 'Adotado',
            self::Dead => 'Óbito',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'gray',
            self::Adopted => 'gray',
            self::Dead => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) { 
            self::Active => 'heroicon-o-check-circle',
            self::Inactive => 'heroicon-o-x-circle',
            self::Adopted => 'heroicon-o-x-circle',
            self::Dead => 'heroicon-o-x-circle',
        };
    }
}
