<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartment_id',
        'sender_name',
        'sender_surname',
        'sender_email',
        'sender_message_object',
        'sender_message_text',
    ];

    // Relazione uno a molti inversa con Apartment
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
