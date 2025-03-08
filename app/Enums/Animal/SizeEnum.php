<?php

namespace App\Enums\Animal;

use Filament\Support\Contracts\HasLabel;

enum SizeEnum: string implements HasLabel
{
    case ExtraSmall = 'xs';
    case Small = 'sm';
    case Medium = 'md';
    case Large = 'lg';
    case ExtraLarge = 'xl';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ExtraSmall => 'Mini',
            self::Small => 'Pequeno',
            self::Medium => 'Médio',
            self::Large => 'Grande',
            self::ExtraLarge => 'Extra Grande',
        };
    }
   
}