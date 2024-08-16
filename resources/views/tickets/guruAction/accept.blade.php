@extends('layouts.guru.sidebar')

@section('contents')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Accept Ticket
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="card mb-4">
                        <div class="card-header">
                            Ticket Details
                        </div>
                        <div class="card-body">
                            <p><strong>Title:</strong> {{ $ticket->title }}</p>
                            <p><strong>Description:</strong> {{ $ticket->description }}</p>
                            <p><strong>Priority:</strong> {{ $ticket->priority }}</p>
                            <p><strong>Status:</strong> {{ $ticket->status }}</p>
                        </div>
                    </div>

                    <form action="{{ route('guru.accept', $ticket->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="scheduled_at">Schedule</label>
                            <input type="datetime-local" class="form-control" id="scheduled_at" name="scheduled_at" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Accept and Schedule</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
