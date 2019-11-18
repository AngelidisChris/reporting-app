@extends('layouts.app')

@section('title', 'Submit new ticket')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>New ticket</h1>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{route('tickets.store')}}" method="post" class="pb-5">
                @include('tickets.form')

                <div class="text-center col-6 offset-3">
                    <button class="btn btn-primary btn-block" type="submit">Submit Ticket</button>
                </div>
            </form>
        </div>
    </div>
@endsection
