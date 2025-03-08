<?php

namespace App\Enums\Animal;

use Filament\Support\Contracts\HasLabel;

enum ExpenseTypeEnum: string implements HasLabel
{
    case ACCOMMODATION = 'accommodation';
    case FOOD = 'food';
    case MEDICATION = 'medication';
    case VETERINARY = 'veterinary';
    case TREATMENT = 'treatment';
    case VACCINATION = 'vaccination';
    case SURGERY = 'surgery';
    case HYGIENE = 'hygiene';
    case ACCESSORIES = 'accessories';
    case TRANSPORT = 'transport';
    case EXAMS = 'exams';
    case TESTS = 'tests';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ACCOMMODATION => 'Hospedagem',
            self::FOOD => 'Ração',
            self::MEDICATION => 'Medicamento',
            self::VETERINARY => 'Veterinário',
            self::TREATMENT => 'Tratamento',
            self::VACCINATION => 'Vacinação',
            self::SURGERY => 'Cirurgia',
            self::HYGIENE => 'Higiene',
            self::ACCESSORIES => 'Acessórios',
            self::TRANSPORT => 'Transporte',            
            self::EXAMS => 'Exames',
            self::TESTS => 'Testes',
            self::OTHER => 'Outros',
        };
    }
}
