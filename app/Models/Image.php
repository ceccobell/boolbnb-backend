<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartament_id',
        'image_url'
    ];

    // Relazione uno a molti inversa con Apartment
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
