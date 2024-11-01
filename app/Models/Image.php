<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartment_id',
        'image_url'
    ];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
