<?php

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdoptionRequest extends Model
{
    protected $fillable = [
        'animal_id',
        'name',
        'email',
        'whatsapp',
        'contacted',
    ];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }
}
