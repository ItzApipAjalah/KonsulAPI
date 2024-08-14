<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // Siswa creates a ticket
    public function createTicket(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'siswa_id' => Auth::id(), // Siswa's ID
        ]);

        return response()->json(['message' => 'Ticket created successfully', 'ticket' => $ticket], 201);
    }

    // Guru views tickets
    public function viewTickets()
    {
        $tickets = Ticket::where('guru_id', null)->where('status', 'pending')->get();
        return response()->json($tickets, 200);
    }

    // Guru accepts a ticket and schedules it
    public function acceptTicket(Request $request, $id)
    {
        $request->validate([
            'scheduled_at' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $ticket = Ticket::where('id', $id)->where('guru_id', null)->first();

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found or already accepted'], 404);
        }

        // Guru accepts and schedules the ticket
        $ticket->update([
            'guru_id' => Auth::id(),
            'scheduled_at' => $request->scheduled_at,
            'status' => 'dijadwalkan',
        ]);

        return response()->json(['message' => 'Ticket accepted and scheduled', 'ticket' => $ticket], 200);
    }

    // Guru closes the ticket
    public function closeTicket($id)
    {
        $ticket = Ticket::where('id', $id)->where('guru_id', Auth::id())->first();

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found or not authorized'], 404);
        }

        $ticket->update(['status' => 'closed']);

        return response()->json(['message' => 'Ticket closed', 'ticket' => $ticket], 200);
    }
}

