<?php

namespace App\Enums\Animal;

use Filament\Support\Contracts\HasLabel;

enum SpecieEnum: string implements HasLabel
{
    case Dog = 'dog';
    case Cat = 'cat';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Dog => 'Cachorro',
            self::Cat => 'Gato',
        };
    }
   
}