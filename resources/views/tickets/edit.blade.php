@extends('layouts.app')

@section('title', 'Edit ticket')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Edit ticket</h1>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{route('tickets.update', ['ticket' => $ticket])}}" method="post" class="pb-5">
                @method('PATCH')
                @include('tickets.form')

                <div class="row pb-5">
                    <div class="text-center col-3 offset-3">
                        <button class="btn btn-primary btn-block" type="submit">Update Ticket</button>
                    </div>
                    <div class="text-center col-3">
                        <a href="/tickets/{{ $ticket->id }}" class="btn btn-block btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
