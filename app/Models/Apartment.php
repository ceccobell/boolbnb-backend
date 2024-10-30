<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// App\Models\Apartment.php

class Apartment extends Model
{
    // Relazione uno a molti inversa con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relazione molti a molti con Sponsor
    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class);
    }

    // Relazione molti a molti con Service
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    // Relazione uno a molti con View
    public function views()
    {
        return $this->hasMany(View::class);
    }

    // Relazione uno a molti con Message
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Relazione uno a molti con Image
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}

