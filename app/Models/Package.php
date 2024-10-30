<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_name',
        'price',
        'hours',
    ];

    // Relazione molti a molti con Sponsor (attraverso la tabella sponsor)
    public function sponsors()
    {
        return $this->hasMany(Sponsor::class);
    }
}
