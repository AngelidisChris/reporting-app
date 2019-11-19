@extends('layouts.app')

@section('title', 'Ticket List')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">

            @if(session()->has('message'))
                <div id="message" class="alert alert-danger message" role="alert">
                    <strong>{{ session()->get('message') }}</strong>
                </div>
            @endif
            <div class="row d-flex align-items-start">
                <h1>Ticket List</h1>
                <a href="/tickets/create" class="btn btn-primary ml-auto">New Ticket</a>
            </div>

            <div class="" style="background-color: white">
                <table class="table js-table table-hover">
                    <thead>
                    <tr>
                        <th>@sortablelink('id')</th>
                        <th>@sortablelink('user_id', 'issuer')</th>
                        <th>@sortablelink('title')</th>
                        <th>@sortablelink('body', 'Subject')</th>
                        <th>@sortablelink('created_at', 'Created')</th>
                        <th>@sortablelink('status')</th>
                        <th>@sortablelink('priority')</th>
                        <th>@sortablelink('due_date', 'Due Date')</th>
                        <th>@sortablelink('tracker')</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr class="table-tr" data-url="/tickets/{{ $ticket->id }}">
                                <td><a class="" href="/tickets/{{ $ticket->id}}">{{ str_pad($ticket->id,3,'0',STR_PAD_LEFT) }}</a></td>
                                <td>{{ $ticket->user->name }}</td>
                                <td>{{ str_limit($ticket->title, 30) }}</td>
                                <td> <span title="{{$ticket->body}}">{{ str_limit($ticket->body, 30) }}</span></td>
                                <td >{{ ($ticket->created_at)->format('d M Y') }}</td>
                                <td><span class="box px-2 py-1 font-weight-bold rounded status-level-{{ $ticket->getOriginal('status') }}">{{ $ticket->status }}</span></td>
                                <td><span class="box px-2 py-1 font-weight-bold rounded priority-level-{{ $ticket->getOriginal('priority') }}">{{ $ticket->priority }}</span></td>
                                <td >{{ ($ticket->due_date)->format('d M Y') }}</td>
                                <td>{{ $ticket->tracker }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection


