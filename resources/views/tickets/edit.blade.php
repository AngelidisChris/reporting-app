@extends('layouts.app')

@section('title', 'Edit ticket')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Edit ticket</h1>
            <hr>
        </div>
    </div>

    <form action="{{route('tickets.update', ['ticket' => $ticket])}}" method="post" class="pb-5">
        @method('PATCH')
        @include('tickets.form')

        <div class="d-flex pt-5">
            <div class="text-center col-md-3 offset-md-3 col-sm-4">
                <button class="btn btn-primary btn-block" type="submit">Update Ticket</button>
            </div>
            <div class="text-center col-md-3 col-sm-4">
                <a href="/tickets/{{ $ticket->id }}" class="btn btn-block btn-danger">Cancel</a>
            </div>
        </div>
    </form>
@endsection
