@extends('layouts.app')

@section('title', 'Ticket Details')
@section('content')


    @if(session()->has('message'))
        <div id="message" class="alert alert-success message" role="alert">
            <strong>{{ session()->get('message') }}</strong>
        </div>
    @endif

    <div class="row d-flex align-items-start pb-2">
        <h2>{{ $ticket->tracker }}</h2>
        <h2 class="pl-2">#{{ str_pad($ticket->id,3,'0',STR_PAD_LEFT) }}</h2>
        <a href="/tickets/{{$ticket->id}}/edit" class="btn btn-primary ml-auto mr-3"><i class="fa fa-pencil pr-2"></i>Edit</a>
        <form action="/tickets/{{$ticket->id}}" method="post">
            @method('DELETE')
            @csrf

            <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure?')"><i class="fa fa-trash-o pr-2"></i>Delete</button>

        </form>
    </div>

    <div class="row pt-4 border">
        <div class="col-12">
            <p class="font-weight-bold">{{ $ticket->title }}</p>
            <span>Added by
                <a href="#">
                    {{ $ticket->user->name }}
                    {{ $ticket->created_at->diffForHumans() }}.
                </a>
                Updated
                <a href="#">
                {{ ($ticket->updated_at)->diffForHumans() }}.
                </a>
            </span>
        </div>

        <div class="col-12">
            <dl class="row pt-4">
                <div class="row col-12">
                    <dt class="col-2">Status:</dt>
                    <dd class="col-3">{{ $ticket->status }}</dd>

                    <dt class="col-2">Start Date:</dt>
                    <dd class="col-3">{{ ($ticket->created_at)->format('d/M/Y') }}</dd>
                </div>
                <div class="row col-12">
                    <dt class="col-2">Priority:</dt>
                    <dd class="col-3">{{ $ticket->priority }}</dd>

                    <dt class="col-2">Due Date:</dt>
                    <dd class="col-3">{{ ($ticket->due_date) ? \Carbon\Carbon::parse($ticket->due_date)->format('d/M/Y') : '-'}}</dd>
                </div>
                <div class="row col-12">
                    <dt class="col-2">Assignee:</dt>
                    <dd class="col-3"><a href="">{{ $ticket->assignedUser->name }}</a></dd>
                </div>
            </dl>
            <hr>
        </div>

        <div class="col-11">
            <p class="font-weight-bold">Description</p>
            <p class="">{{ $ticket->body }}</p>
        </div>


    </div>



{{--    <div class="row pt-4 border">--}}
{{--        <div class="col-10">--}}
{{--            <p>--}}
{{--            <span class="font-weight-bold">{{$ticket->user->name}}</span>--}}
{{--            &lt;{{$ticket->user->email}}&gt; {{ \Carbon\Carbon::parse($ticket->created_at)->format('M d, Y, h:m') }}--}}
{{--            </p>--}}
{{--        </div>--}}
{{--        <div class="col-10">--}}
{{--            <p>{{ $ticket->body }}</p>--}}
{{--        </div>--}}
{{--    </div>--}}

@endsection
