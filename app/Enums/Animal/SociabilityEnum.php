<?php

namespace App\Enums\Animal;

use Filament\Support\Contracts\HasLabel;

enum SociabilityEnum: string implements HasLabel
{
    case Yes = 'y';
    case No = 'n';
    case NotEvaluated = 'n/e';

    public function getLabel(): string
    {
        return match ($this) {
            self::Yes => 'Sim',
            self::No => 'Não',
            self::NotEvaluated => 'Não Avaliado',
        };
    }
   
}