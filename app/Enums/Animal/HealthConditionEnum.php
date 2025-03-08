<?php

namespace App\Enums\Animal;

use Filament\Support\Contracts\HasLabel;

enum HealthConditionEnum: string implements HasLabel
{    
    case HeartDisease = 'heart_disease';
    case KidneyDisease = 'kidney_disease';
    case RespiratoryDisease = 'respiratory_disease';
    case Obesity = 'obesity';
    case Allergies = 'allergies';
    case FoodAllergies = 'food_allergies';
    case EnvironmentalAllergies = 'environmental_allergies';
    case FivFelv = 'fiv_felv';
    case Epilepsy = 'epilepsy';
    case DentalIssues = 'dental_issues';
    case Deafness = 'deafness';
    case Blindness = 'blindness';
    case PartialBlindness = 'partial_blindness';
    case PhysicalDisability = 'physical_disability';
    case ReducedMobility = 'reduced_mobility';
    case Trauma = 'trauma';
    case Elderly = 'elderly';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::HeartDisease => 'Doenca Cardíaca',
            self::KidneyDisease => 'Doenca Renal',
            self::RespiratoryDisease => 'Doenca Respiratoria',
            self::Obesity => 'Obesidade',
            self::Allergies => 'Alergias',
            self::FoodAllergies => 'Alergias Alimentares',
            self::EnvironmentalAllergies => 'Alergias Ambientais',
            self::FivFelv => 'Fiv Felv',
            self::Epilepsy => 'Epilepsia',
            self::DentalIssues => 'Problemas Dentarios',
            self::Deafness => 'Surdez',
            self::Blindness => 'Cegueira',
            self::PartialBlindness => 'Cegueira Parcial',
            self::PhysicalDisability => 'Deficiencia Fisica',
            self::ReducedMobility => 'Mobilidade Reduzida',
            self::Trauma => 'Traumas',
            self::Elderly => 'Idoso',
        };
    }
   
}