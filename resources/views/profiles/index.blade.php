@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-2 pt-5">
            <img src="{{ $user->profile->profileImage() }}" alt="" class="rounded-circle w-100">
        </div>
        <div class="col-sm-6   pt-5 pl-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-3">
                    <div class="h1">{{ $user->name }}</div>
                 </div>

            </div>
            @can('update', $user->profile)
                <a href="/profile/{{$user->id}}/edit">Edit Profile</a>
            @endcan

            <div class="d-flex">
                <div class="pr-5"><strong>{{ $ticketsCreatedCount }}</strong> Tickets</div>
                <div class="pr-5"><strong>{{ $ticketsAssignedCount }}</strong> Assigned</div>
            </div>
            <div class="pt-4 font-weight-bold">{{$user->profile->title}} </div>
            <div><i class="fa fa-envelope pr-2" aria-hidden="true"></i><a href="mailto:{{$user->email}}">{{$user->email}}</a></div>
            <div>
                <span class="text-black-50">Member since</span>
                <p>{{($user->created_at)->format('d-M-Y')}}</p>
            </div>
        </div>
    </div>
    <hr>

    <section id="tabs" class="project-tab">

            <div class="row">
                <div class="col-12">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Tickets Created </a>
                            <a class="nav-item nav-link adjust_table" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Tickets Assigned</a>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane table-responsive fade show active pt-4" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                @if($ticketsCreatedCount != 0)
                                <table id="dataTable" class="dataTable display table-responsive table js-table table-hover text-center">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
{{--                                        <th>Issuer</th>--}}
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
                                    @foreach($ticketsCreated as $ticket)
                                        <tr class="table-tr" data-url="/tickets/{{ $ticket->id }}">
                                            <td><a class="" href="/tickets/{{ $ticket->id}}">{{ str_pad($ticket->id,3,'0',STR_PAD_LEFT) }}</a></td>
{{--                                            <td><a href="/profile/{{ $ticket->user_id }}">{{ $ticket->user->name }}</a></td>--}}
                                            <td><a href="{{ ($ticket->assigned_to) ? ('/profile/' . $ticket->assigned_to) : '' }}">{{ ($ticket->assignedUser != null) ? $ticket->assignedUser->name : '' }}</a></td>
                                            <td><span title="{{$ticket->title}}">{{ str_limit($ticket->title, 40) }}</span></td>
                                            <td>{{ ($ticket->created_at)->format('d/m/y') }}</td>
                                            <td data-order="{{ $ticket->getOriginal('status') }}"><span class="box px-2 py-1 font-weight-bold rounded status-level-{{ $ticket->getOriginal('status') }}">{{ $ticket->status }}</span></td>
                                            <td data-order="{{ $ticket->getOriginal('priority') }}" class="text-nowrap"><span class="box px-2 py-1 font-weight-bold rounded priority-level-{{ $ticket->getOriginal('priority') }} ">{{ $ticket->priority }}</span></td>
                                            <td class="text-nowrap">{{ ($ticket->due_date) ?($ticket->due_date)->format('d M Y') : ''}}</td>
                                            <td>{{ $ticket->tracker }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                    <div class="pt-4">
                                        <span class="font-weight-bold offset-4 text-center">No tickets created.</span>
                                    </div>

                                @endif
                            </div>

                            <div class="tab-pane fade table-responsive pt-4" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                @if($ticketsAssigned->count() != 0)
                                    <table id="dataTable2" class="dataTable display table-responsive table js-table table-hover text-center ">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Issuer</th>
{{--                                            <th>Assignee</th>--}}
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
                                        @foreach($ticketsAssigned as $ticket)
                                            <tr class="table-tr" data-url="/tickets/{{ $ticket->id }}">
                                                <td><a href="/tickets/{{ $ticket->id}}">{{ str_pad($ticket->id,3,'0',STR_PAD_LEFT) }}</a></td>
                                                <td><a href="/profile/{{ $ticket->user_id }}">{{ $ticket->user->name }}</a></td>
{{--                                                <td><a href="{{ ($ticket->assigned_to) ? '/profile/' . $ticket->assigned_to : ''}}">{{!is_null($ticket->assignedUser) ? $ticket->assignedUser->name : '' }}</a></td>--}}
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
                                @else
                                    <div class="pt-4">
                                        <span class="font-weight-bold offset-4 text-center">No tickets assigned to {{ $user->name }}</span>
                                    </div>

                                @endif
                            </div>
                        </div>
                    </nav>

                </div>
            </div>
    </section>
    <!-- ./Tabs -->
@endsection

@section('pagespecificscripts')
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable(
                {
                    "order": [[ 3, 'desc' ],],
                    "columnDefs": [
                        {"width": "5%", "targets": 0},
                        {"width": "10%", "targets": 1},
                        {"width": "45%", "targets": 2},
                        {"width": "10%", "targets": 3},
                        {"width": "8%", "targets": 4},
                        {"width": "8%", "targets": 5},
                        {"width": "8%", "targets": 6},
                        {"width": "6%", "targets": 7},
                        {
                        "targets"  : 2,
                        "orderable": false,
                        "order": []
                    }]
                }
            )

            $('#dataTable2').DataTable(
                {
                    autoWidth: false, //<---
                    responsive : true,

                    "order": [[ 3, 'desc' ],],
                    "columnDefs": [
                        {"width": "5%", "targets": 0},
                        {"width": "10%", "targets": 1},
                        {"width": "45%", "targets": 2},
                        {"width": "10%", "targets": 3},
                        {"width": "8%", "targets": 4},
                        {"width": "8%", "targets": 5},
                        {"width": "8%", "targets": 6},
                        {"width": "6%", "targets": 7},
                        {
                        "targets"  : 2,
                        "orderable": false,
                        "order": []
                    }]
                }
            )
        } );


        window.onresize = function () {
            $('#dataTable2').DataTable()
                .columns.adjust()
                .responsive.recalc();
        };



    </script>
@endsection
