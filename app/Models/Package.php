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

    public function apartments()
    {
        return $this->belongsToMany(Apartment::class)->withPivot('sponsorship_start', 'sponsorship_end')->withTimestamps();
    }

}
