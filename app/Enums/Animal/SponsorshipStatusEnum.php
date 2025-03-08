<?php

namespace App\Enums\Animal;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum SponsorshipStatusEnum: string implements HasLabel, HasColor, HasIcon
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Pending = 'pending';

    public function getLabel(): string
    {
        return match ($this) {
            self::Active => 'Ativo',
            self::Inactive => 'Inativo',
            self::Pending => 'Pendente'
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'gray',
            self::Pending => 'danger'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) { 
            self::Active => 'heroicon-o-check-circle',
            self::Inactive => 'heroicon-o-x-circle',
            self::Pending => 'heroicon-o-x-circle',
        };
    }
}
