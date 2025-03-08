<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DropoffLocation extends Model
{
    Use HasFactory;

    protected $table = 'dropoff_locations';

    protected $fillable = [
        'name',
        'address',
        'number',
        'complement',
        'city',
        'state', 
        'zip_code', 
        'phone',
        'whatsapp',
    ];
}
