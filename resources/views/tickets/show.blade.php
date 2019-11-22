@extends('layouts.app')

@section('title', 'Ticket Details')
@section('content')


    @if(session()->has('message'))
        <div id="message" class="alert alert-success message" role="alert">
            <strong>{{ session()->get('message') }}</strong>
        </div>
    @endif

    <div class="header row d-flex align-items-start pb-2">
        <h2>{{ $ticket->tracker }}</h2>

        <h2 class="pl-2">#{{ str_pad($ticket->id,3,'0',STR_PAD_LEFT) }}</h2>
        {{--  use update policy to hide update button   --}}
        @can('update', $ticket)
            <a href="/tickets/{{$ticket->id}}/edit" class="btn btn-primary ml-auto mr-3"><i class="fa fa-pencil pr-2"></i>Edit</a>
        @endcan
            {{--   use delete policy to hide delete button   --}}
            @can('delete', $ticket)
            <form action="/tickets/{{$ticket->id}}" method="post">
                @method('DELETE')
                @csrf

                <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure?')"><i class="fa fa-trash-o pr-2"></i>Delete</button>
            </form>
        @endcan
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
                    <dd class="col-3"><a id="assignee-name" href="">{{($ticket->assignedUser) ? $ticket->assignedUser->name : '' }}</a>
                        @can('update', $ticket)
                            <a href="#" class="remove_assignee" id="remove" assignee-id="{{ $ticket->id }}"> </a>
                        @endcan
                    </dd>

                </div>
            </dl>
            <hr>
        </div>

        <div class="col-11">
            <p class="font-weight-bold">Description</p>
            <p class="">{{ $ticket->body }}</p>
        </div>


    </div>

{{--    // history section--}}
    <div class="history-log row pt-4">
        <h2>History log</h2>
    </div>

    <div class="row">

        @foreach($ticket->group_by('created_at', $ticket->revisionHistory) as $history)
            <div class="col-10 border pt-2 pb-2 mb-3">
                @if($history[0]->key == 'created_at' && !$history[0]->old_value)
                    <div class="font-weight-bold pl-1">
                    <span class="">Created by &nbsp;<a href="#">
                        {{ $history[0]->userResponsible()->name }}
                        &nbsp;{{ \Carbon\Carbon::parse($history[0]->newValue())->diffForHumans() }}</a>
                    </span>
                    </div>

                @else
                    <span class="font-weight-bold">Updated by &nbsp;<a href="#">
                        {{ $history[0]->userResponsible()->name }}
                        &nbsp;{{ \Carbon\Carbon::parse($history[0]->created_at)->diffForHumans() }}</a>
                    </span>
                    <div class=" col-12 pt-3">
                        @foreach($history as $his)
                            <div class="col-12 log-section">
                                @if($his->fieldName() != 'z')
                                    @if($his->oldValue() != null && $his->newValue() == null)
                                        <span class="font-weight-bold">{{ $his->fieldName() }}</span>&nbsp; unset &nbsp;
                                        @if($his->fieldName() == 'Assignee')
                                            <a href=""> {{ $ticket->getTableValues($his->fieldName(), $his->oldValue()) }}</a>
                                        @else
                                            {{$ticket->getTableValues($his->fieldName(), $his->oldValue())}}
                                        @endif
                                    @elseif($his->oldValue() == null && $his->newValue() != null)
                                        <span class="font-weight-bold">{{ $his->fieldName() }}</span>&nbsp; set to &nbsp;
                                        @if($his->fieldName() == 'Assignee')
                                            <a href=""> {{$ticket->getTableValues($his->fieldName(), $his->newValue()) }}</a>
                                        @else
                                            {{$ticket->getTableValues($his->fieldName(), $his->newValue()) }}
                                        @endif
                                    @elseif($his->oldValue() != null && $his->newValue() != null)
                                        <span class="font-weight-bold">{{ $his->fieldName() }}</span>&nbsp; changed from &nbsp;
                                        @if($his->fieldName() == 'Assignee')
                                            <a href=""> {{ $ticket->getTableValues($his->fieldName(), $his->oldValue()) }} </a>
                                            &nbsp;to&nbsp;<a href=""> {{ $ticket->getTableValues($his->fieldName(), $his->newValue()) }} </a>
                                        @else
                                            {{ $ticket->getTableValues($his->fieldName(), $his->oldValue()) }}
                                            &nbsp;to&nbsp;{{ $ticket->getTableValues($his->fieldName(), $his->newValue()) }}
                                        @endif
                                    @endif
                                @endif

                            </div>

                            @if($his->fieldName() == 'z')

                                <div class="pt-4">
                                <p class="font-weight-bold">{{$his->newValue()}}</p>
                                </div>
                            @endif

                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach

    </div>



{{--    // remove div if no assignee, else add delete button--}}
@section('pagespecificscripts')
    <!-- flot charts scripts-->
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            if (document.getElementById('assignee-name').innerHTML == '')
            {
                document.getElementById('remove').remove();
            }
            else{
                document.getElementById('remove').innerHTML = '<i class=\'fa fa-times fa-lg pl-1\' style=\'color: red\' aria-hidden=\'true\'></i>'

            }
        });

    </script>
@stop
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
