<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Dotenv\Util\Regex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{ 
    public function indexTicket(Request $request)
    {
        $userId = auth()->user()->id;
        
        $filter = $request->query('filter', 'all'); // Default filter is 'all'

        // Query builder awal
        $query = Ticket::with('siswa')->where('siswa_id', $userId);

        // Terapkan filter
        if ($filter === 'guru_kosong') {
            $query->whereNull('guru_id');
        }

        $tickets = $query->get();

        return view('tickets.index', compact('tickets'));
    }

    public function createTicket(){
        return view('tickets.create');
    }

    public function storeTicket(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'siswa_id' => Auth::id()
        ]);

        // $tickets->user()->sync($request->siswa_id);

        return redirect()->route('ticket.index')
        ->with('success', 'Product created successfully.');
    }

    public function editTicket(Ticket $ticket) {
        return view('tickets
        .edit', compact('ticket'));
    }

    public function updateTicket(Request $request, Ticket $ticket) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);
    
        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'siswa_id' => Auth::id(),
        ]);
    
        return redirect()->route('ticket.index')
            ->with('success', 'Ticket updated successfully.');
    }
    
    public function destroyTicket($id){
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('ticket.index')
        ->with('success', 'Product deleted successfully.');
    }

    //Fungsi action guru
    public function myTicketsForGuru(Request $request)  
    {
        $filter = $request->query('filter', 'all');
        
        $query = Ticket::with('guru');

        if($filter === 'guru_kosong'){
            
                $query->where('guru_id', null)
                    ->where('status', 'pending');
            
        }

        $tickets = $query->get();
                        
        return view('tickets.guruAction.index', compact('tickets'));
    }

    public function acceptTicket(Request $request, $id){
        $request->validate([
            'scheduled_at' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $ticket = Ticket::where('id', $id)->where('guru_id', null)->first();

        if (!$ticket) {
            return redirect()->route('guru.ticket')
                ->with('error', 'Ticket not found or already accepted.');
        }

        $scheduledAt = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->scheduled_at)
                                    ->format('Y-m-d H:i:s');
    
        $ticket->update([
            'guru_id' => Auth::id(),
            'scheduled_at' => $scheduledAt,
            'status' => 'scheduled',
        ]);

        return redirect()->route('guru.ticket')
            ->with('success', 'Ticket accepted and scheduled successfully.');
    }

    
    public function showAcceptForm($id)
    {
        $ticket = Ticket::where('id', $id)->where('guru_id', null)->first();

        if (!$ticket) {
            return redirect()->route('guru.ticket')
                ->with('error', 'Ticket not found or already accepted.');
        }

        return view('tickets.guruAction.accept', compact('ticket'));
    }

}

