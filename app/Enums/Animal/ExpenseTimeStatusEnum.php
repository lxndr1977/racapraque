<?php

namespace App\Enums\Animal;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ExpenseTimeStatusEnum: string implements HasLabel, HasColor
{
    case NotStarted = 'not_started';
    case InProgress = 'in_progress';
    case Closed = 'closed';

    public function getLabel(): string
    {
        return match ($this) {
            self::NotStarted => 'Não Iniciada',
            self::InProgress => 'Em Andamento',
            self::Closed => 'Encerrada',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::NotStarted => 'warning',
            self::InProgress => 'info',
            self::Closed => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) { 
            self::NotStarted => 'heroicon-o-clock',
            self::InProgress => 'heroicon-o-check-circle',
            self::Closed => 'heroicon-o-x-circle',
        };
    }
}
