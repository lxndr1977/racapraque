<?php

namespace App\Enums\Animal;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ExpenseRecurrenceEnum: string implements HasLabel
{
    case OneTime = '0';
    case Monthly = '30';
    case Semiannual = '180';
    case Annually = '360';

    public function getLabel(): string
    {
        return match ($this) {
            self::OneTime => 'Única',
            self::Monthly => 'Mensal',
            self::Semiannual => 'Semestral',
            self::Annually => 'Anual',
        };
    }
}
