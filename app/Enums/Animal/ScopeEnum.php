<?php

namespace App\Enums\Animal;

enum ScopeEnum: string
{
    case Adoptables = 'adoptables';
    case Sponsorables = 'sponsorables';
    case Actives = 'actives';
}
