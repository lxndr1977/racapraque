<?php

namespace App\Enums\Animal;

use Filament\Support\Contracts\HasLabel;

enum TemperamentEnum: string implements HasLabel
{
    case FRIENDLY = 'friendly';
    case PLAYFUL = 'playful';
    case PROTECTIVE = 'protective';
    case CALM = 'calm';
    case INDEPENDENT = 'independent';
    case SHY = 'shy';
    case ENERGETIC = 'energetic';
    case CURIOUS = 'curious';
    case AFFECTIONATE = 'affectionate';
    case DOMINANT = 'dominant';
    case SUBMISSIVE = 'submissive';
    case VOCAL = 'vocal';
    case QUIET = 'quiet';
    case ANXIOUS = 'anxious';
    case FEARFUL = 'fearful';
    case ALERT = 'alert';
    case GENTLE = 'gentle';
    case SOCIAL = 'social';
    case TERRITORIAL = 'territorial';
    case HUNTING_INSTINCT = 'hunting_instinct';
    case LAP_PET = 'lap_pet';
    case TRAINABLE = 'trainable';
    case STUBBORN = 'stubborn';
    case LAZY = 'lazy';
    case AGGRESSIVE = 'aggressive';
    case REACTIVE = 'reactive';
    case DEFENSIVE = 'defensive';
    case FEAR_AGGRESSIVE = 'fear_aggressive';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::FRIENDLY => 'Amigável',
            self::PLAYFUL => 'Brincalhão',
            self::PROTECTIVE => 'Protetor',
            self::CALM => 'Calmo',
            self::INDEPENDENT => 'Independente',
            self::SHY => 'Tímido',
            self::ENERGETIC => 'Energético',
            self::CURIOUS => 'Curioso',
            self::AFFECTIONATE => 'Afeituoso',
            self::DOMINANT => 'Dominante',
            self::SUBMISSIVE => 'Submisso',
            self::VOCAL => 'Vocaliza muito',
            self::QUIET => 'Silencioso',
            self::ANXIOUS => 'Ansioso',
            self::FEARFUL => 'Medroso',
            self::ALERT => 'Alerta',
            self::GENTLE => 'Gentil',
            self::SOCIAL => 'Sociável',
            self::TERRITORIAL => 'Territorial',
            self::HUNTING_INSTINCT => 'Instinto de caça',
            self::LAP_PET => 'Gosta de colo',
            self::TRAINABLE => 'Treinável',
            self::STUBBORN => 'Teimoso',
            self::LAZY => 'Preguiçoso',
            self::AGGRESSIVE => 'Agressivo',
            self::REACTIVE => 'Reativo',
            self::DEFENSIVE => 'Defensivo',
            self::FEAR_AGGRESSIVE => 'Agressivo por medo',
        };
    }

}
