<?php

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Model;

class AdoptionRequest extends Model
{
    protected $fillable = [
        'animal_id',
        'name',
        'email',
        'whatsapp',
    ];
}
