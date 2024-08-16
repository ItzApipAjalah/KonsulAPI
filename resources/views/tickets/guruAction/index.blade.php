@extends('layouts.guru.sidebar')

@section('contents')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <a href="{{ route('guru.ticket', ['filter' => 'all']) }}" class="btn btn-success">Semua Tiket</a>
                    <a href="{{ route('guru.ticket', ['filter' => 'guru_kosong']) }}" class="btn btn-danger">Guru Kosong</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Guru yang Mengambil</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ticket->title }}</td>
                                    <td>{{ $ticket->description }}</td>
                                    <td>{{ $ticket->priority }}</td>
                                    <td>{{ $ticket->status }}</td>
                                    <td>
                                        @if($ticket->guru)
                                            {{ $ticket->guru->name }}
                                        @else
                                            Tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('guru.showAcceptForm', $ticket->id) }}" class="btn btn-info btn-sm">Accept</a>
                                    </td>
                                </tr>

                                <!-- Modal for Ticket Details -->
                                {{-- <div class="modal fade" id="ticketDetailModal{{ $ticket->id }}" tabindex="-1" role="dialog" aria-labelledby="ticketDetailModalLabel{{ $ticket->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ticketDetailModalLabel{{ $ticket->id }}">Ticket Details</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Title:</strong> {{ $ticket->title }}</p>
                                                <p><strong>Description:</strong> {{ $ticket->description }}</p>
                                                <p><strong>Priority:</strong> {{ $ticket->priority }}</p>
                                                <p><strong>Status:</strong> {{ $ticket->status }}</p>
                                                <p><strong>Guru yang Mengambil:</strong> 
                                                    @if($ticket->guru)
                                                        {{ $ticket->guru->name }}
                                                    @else
                                                        Tidak ada
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <!-- Delete Confirmation Modal -->
                                {{-- <div class="modal fade" id="deleteModal{{ $ticket->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $ticket->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $ticket->id }}">Confirm Delete</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this ticket?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('ticket.destroy', $ticket->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            @endforeach
                        </tbody>
                    </table>

                    

                    {{-- <div class="d-flex justify-content-center">
                        {{ $tickets->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
