<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // Relazione molti a molti con Apartment (attraverso la tabella pivot `apartment_service`)
    public function apartments()
    {
        return $this->belongsToMany(Apartment::class, 'apartment_service');
    }
}
