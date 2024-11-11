<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'property',
        'city',
        'address',
        'description',
        'n_rooms',
        'n_beds',
        'n_bathrooms',
        'square_meters',
        'latitude',
        'longitude',
        'status',
        'main_image_id',
    ];

    public static function generateSlug($property)
    {
        return Str::slug($property, '-');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function packages()
    {
        return $this->belongsToMany(Package::class)->withPivot('sponsorship_start', 'sponsorship_end')->withTimestamps();
    }


    public function services()
    {
        return $this->belongsToMany(Service::class);
    }


    public function views()
    {
        return $this->hasMany(View::class);
    }


    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }


    public function mainImage()
    {
        return $this->hasOne(Image::class)->where('is_main', true);
    }


    /* public function getMainImageUrlAttribute()
    {

        if ($this->main_image_id) {
            return $this->main_image_id->url;
        }

        return 'https://via.placeholder.com/600x400.png?text=Immagine%20non%20disponibile'; // URL dell'immagine di placeholder online
    } */
}
