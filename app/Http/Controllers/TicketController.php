<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function createTicket(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'siswa_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Ticket created successfully', 'ticket' => $ticket], 201);
    }

    public function viewTickets()
    {
        $tickets = Ticket::where('guru_id', null)->where('status', 'pending')->get();
        return response()->json($tickets, 200);
    }

    public function myTicketsForGuru()
    {
        $tickets = Ticket::where('guru_id', Auth::id())
                         ->orWhere(function($query) {
                             $query->where('guru_id', null)
                                   ->where('status', 'pending');
                         })
                         ->get();

        return response()->json($tickets, 200);
    }


    public function myTickets()
    {
        // Retrieve tickets created by the authenticated siswa
        $tickets = Ticket::where('siswa_id', Auth::id())->get();

        return response()->json($tickets, 200);
    }

    public function acceptTicket(Request $request, $id)
    {
        $request->validate([
            'scheduled_at' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $ticket = Ticket::where('id', $id)->where('guru_id', null)->first();

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found or already accepted'], 404);
        }

        $ticket->update([
            'guru_id' => Auth::id(),
            'scheduled_at' => $request->scheduled_at,
            'status' => 'scheduled',
        ]);

        return response()->json(['message' => 'Ticket accepted and scheduled', 'ticket' => $ticket], 200);
    }

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

