@extends('layouts.app')

@section('title', 'Ticket List')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 message-parent">

            @if(session()->has('message'))
                <div id="message" class="alert alert-danger message" role="alert">
                    <strong>{{ session()->get('message') }}</strong>
                </div>
            @endif

            @if(session()->has('create-message'))
                <div id="message" class="alert alert-success message" role="alert">
                    <strong>{{ session()->get('create-message') }}</strong>
                </div>
            @endif
            <div class="row d-flex align-items-start">
                <h1>Ticket List</h1>
                <a href="/tickets/create" class="btn btn-primary ml-auto">New Ticket</a>
            </div>


        </div>
    </div>
</div>

<!-- ### $App Screen Content ### -->
<main class='main-content bgc-grey-100'>
    <div id='mainContent'>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <table id="dataTable" class="dataTable table display table-responsive   js-table table-hover text-center" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Issuer</th>
                                <th>Assignee</th>
                                <th class="">Subject</th>
                                {{--                        <th>@sortablelink('body', 'Subject')</th>--}}
                                <th>Created</th>
                                <th>Status</th>
                                <th class="">Priority</th>
                                <th class="">Due Date</th>
                                <th>Tracker</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($tickets as $ticket)
                                <tr class="table-tr" data-url="/tickets/{{ $ticket->id }}">
                                    <td><a class="" href="/tickets/{{ $ticket->id}}">{{ str_pad($ticket->id,3,'0',STR_PAD_LEFT) }}</a></td>
                                    <td><a href="/profile/{{ $ticket->user_id }}">{{ $ticket->user->name }}</a></td>
                                    <td><a href="{{ ($ticket->assigned_to) ? '/profile/' . $ticket->assigned_to : ''}}">{{!is_null($ticket->assignedUser) ? $ticket->assignedUser->name : '' }}</a></td>
                                    <td><span title="{{$ticket->title}}">{{ str_limit($ticket->title, 40) }}</span></td>
                                    <td >{{ ($ticket->created_at)->format('d/m/y') }}</td>
                                    <td data-order="{{ $ticket->getOriginal('status') }}"><span class="box px-2 py-1 font-weight-bold rounded status-level-{{ $ticket->getOriginal('status') }}">{{ $ticket->status }}</span></td>
                                    <td data-order="{{ $ticket->getOriginal('priority') }}" class="text-nowrap"><span class="box px-2 py-1 font-weight-bold rounded priority-level-{{ $ticket->getOriginal('priority') }} ">{{ $ticket->priority }}</span></td>
                                    <td class="text-nowrap">{{ ($ticket->due_date) ?($ticket->due_date)->format('d M Y') : ''}}</td>
                                    <td>{{ $ticket->tracker }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main><!-- ### $App Screen Content ### -->
@endsection

@section('pagespecificscripts')
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable(
                {
                    "order": [[ 4, 'desc' ],],
                    "columnDefs": [ {
                        "targets"  : 3,
                        "orderable": false,
                        "order": []
                    }]
                }


            )

        } );
    </script>
@endsection


