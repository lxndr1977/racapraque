<?php

namespace App\Enums\Animal;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum LocationTypeEnum: string implements HasLabel, HasColor, HasIcon
{
    case Voluntary = '1';
    case Paid = '0';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Voluntary => 'Voluntário',
            self::Paid => 'Pago',
        };
    }
    
    public function getColor(): ?string
    {
        return match ($this) {
            self::Voluntary => 'success',
            self::Paid => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) { 
            self::Voluntary => 'heroicon-o-check-circle',
            self::Paid => 'heroicon-o-x-circle',
        };
    }

    public static function getIcons(): array
    {
        return [
            self::Voluntary->value => self::Voluntary->getIcon(),
            self::Paid->value => self::Paid->getIcon(),
        ];
    }

    public static function getColors(): array
    {
        return [
            self::Voluntary->value => self::Voluntary->getColor(),
            self::Paid->value => self::Paid->getColor(),
        ];
    }
}