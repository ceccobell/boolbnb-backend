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
            'sender_name' => 'nullable|string|max:255',
            'sender_email' => 'required|email|max:255',
            'sender_message_text' => 'required|string',
        ]);

        $message = Message::create([
            'apartment_id' => $validatedData['apartment_id'],
            'sender_name' => $validatedData['sender_name'] ?? null,
            'sender_email' => $validatedData['sender_email'],
            'sender_message_text' => $validatedData['sender_message_text'],
        ]);

        return response()->json(['message' => 'Message sent successfully!'], 201);
    }
}
