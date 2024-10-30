<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartament_id',
        'view_date',
        'ip_address',
    ];

    // Relazione uno a molti inversa con Apartment
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
