<?php

namespace App\Enums\Animal;

use Filament\Support\Contracts\HasLabel;

enum GenderEnum: string implements HasLabel
{
    case Male = 'm';
    case Female = 'f';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Male => 'Macho',
            self::Female => 'Fêmea',
        };
    }
   
}