<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'apartment_id' => 'required|exists:apartments,id',
            'sender_name' => 'required|string|max:255',
            'sender_surname' => 'required|string|max:255',
            'sender_email' => 'required|email|max:255',
            'sender_message_text' => 'required|string',
            'sender_message_object' => 'required|string|max:255|',
        ]);

        $message = Message::create([
            'apartment_id' => $validatedData['apartment_id'],
            'sender_name' => $validatedData['sender_name'],
            'sender_surname' => $validatedData['sender_surname'],
            'sender_email' => $validatedData['sender_email'],
            'sender_message_text' => $validatedData['sender_message_text'],
            'sender_message_object' => $validatedData['sender_message_object'],
        ]);

        return response()->json(['message' => 'Message sent successfully!'], 201);
    }

    public function getMessagesByApartment($apartment_id)
    {
        // Recupera i messaggi non letti
        $unreadMessages = Message::where('apartment_id', $apartment_id)
            ->where('message_seen', false)
            ->orderByDesc('created_at')
            ->get();

        // Recupera i messaggi letti
        $readMessages = Message::where('apartment_id', $apartment_id)
            ->where('message_seen', true)
            ->orderByDesc('created_at')
            ->get();

        // Restituisci la risposta con i messaggi letti e non letti separati
        return response()->json([
            'unreadMessages' => $unreadMessages,
            'readMessages' => $readMessages,
        ]);
    }

    public function markAsRead($message_id)
    {
        // Trova il messaggio con l'ID fornito
        $message = Message::find($message_id);

        // Verifica se il messaggio esiste
        if (!$message) {
            return response()->json(['error' => 'Message not found'], 404);
        }

        // Se il messaggio non è già stato letto, aggiorna il campo message_seen
        if (!$message->message_seen) {
            $message->message_seen = true;
            $message->save(); // Salva l'aggiornamento nel database
            return response()->json(['message' => 'Message marked as read']);
        }

        // Se il messaggio è già stato letto, restituisci un messaggio
        return response()->json(['message' => 'Message is already marked as read']);
    }


}
