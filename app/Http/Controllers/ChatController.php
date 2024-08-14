<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request, $ticket_id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $ticket = Ticket::findOrFail($ticket_id);

        if (Auth::id() !== $ticket->siswa_id && Auth::id() !== $ticket->guru_id) {
            return response()->json(['message' => 'Unauthorized to send messages on this ticket'], 403);
        }

        $message = Message::create([
            'ticket_id' => $ticket->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return response()->json(['message' => 'Message sent successfully', 'data' => $message], 201);
    }

    public function getMessages($ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);

        if (Auth::id() !== $ticket->siswa_id && Auth::id() !== $ticket->guru_id) {
            return response()->json(['message' => 'Unauthorized to view messages on this ticket'], 403);
        }

        $messages = $ticket->messages()->with('sender:id,name')->get();

        return response()->json($messages, 200);
    }
}
