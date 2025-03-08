<?php

namespace App\Enums\Animal;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ExpenseStatusEnum: string implements HasLabel, HasColor, HasIcon
{
    case NotStarted = 'not_started';
    case Active = 'active';
    case Closed = 'closed';
    case Sponsored = 'sponsored';
    case ClosedWithoutSponsorship = 'closed_without_sponsorship';


    public function getLabel(): string
    {
        return match ($this) {
            self::NotStarted => 'Não Iniciada',
            self::Active => 'Em aberto',
            self::Closed => 'Encerrada',
            self::Sponsored => 'Apadrinhada',
            self::ClosedWithoutSponsorship => 'Incompleta',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::NotStarted => 'gray',
            self::Active => 'warning',
            self::Closed => 'gray',
            self::Sponsored => 'success',
            self::ClosedWithoutSponsorship => 'danger',

        };
    }

    public function getIcon(): ?string
    {
        return match ($this) { 
            self::NotStarted => 'heroicon-o-clock',
            self::Active => 'heroicon-o-information-circle',
            self::Closed => 'heroicon-o-x-circle',
            self::Sponsored => 'heroicon-o-check-circle',
            self::ClosedWithoutSponsorship => 'heroicon-o-x-circle',
        };
    }
}
