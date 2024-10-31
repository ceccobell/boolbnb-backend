<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartment_id',
        'package_id',
        'sponsor_start',
        'sponsor_end',
    ];

    // Relazione uno a molti inversa con Apartment
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    // Relazione uno a molti inversa con Package
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
