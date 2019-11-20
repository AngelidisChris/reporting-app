@csrf

{{-- tracker input --}}
<div class="form-group col-3">

    <label class="font-weight-bold col-form-label" >Tracker</label>
    <label style="color: red" for="">*</label>
    <select name="tracker" id="tracker" class="form-control @error('tracker') is-invalid @enderror">
        <option value="" disabled>Select Tracker Type</option>
        @foreach($ticket->trackerOptions() as $activeTrackerKey => $activeTrackerValue)
            <option value="{{ $activeTrackerKey }}" {{ $ticket->tracker == $activeTrackerValue ? 'selected' : ''}}>{{ $activeTrackerValue }}</option>
        @endforeach

    </select>
    @error('tracker')
    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('tracker') }}</strong></span>
    @enderror
</div>

{{-- subject input --}}
<div class="form-group col-12">
    <label class="font-weight-bold col-form-label" for="title">Title</label>
    <label style="color: red" for="">*</label>
    <input id="title" name="title" type="text" value="{{ old('title') ?? $ticket->title }}" placeholder="Title" class="form-control @error('title') is-invalid @enderror">

    @error('title')
    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('title') }}</strong></span>
    @enderror
</div>

{{-- description input --}}
<div class="form-group col-12">
    <label for="body" class="font-weight-bold col-form-label">Description</label>
    <label style="color: red" for="">*</label>
    <textarea
           id="body"
           type="text"
           rows="5"
           class="form-control @error('body') is-invalid @enderror"
           name="body"
           placeholder="Ticket content">{{ old('body') ?? $ticket->body }}
    </textarea>

    @error('body')
    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('body') }}</strong></span>
    @enderror
</div>

<div class="row col-12">
    {{-- status input  --}}
    <div class="form-group col-3">

        <label class="font-weight-bold col-form-label" >Status</label>
        <label style="color: red" for="">*</label>

        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
            <option value="" disabled>Select Tracker Status</option>
            @foreach($ticket->statusOptions() as $activeStatusKey => $activeStatusValue)
                <option value="{{ $activeStatusKey }}" {{ $ticket->status == $activeStatusValue ? 'selected' : ''}}>{{ $activeStatusValue }}</option>
            @endforeach
        </select>

        @error('status')
        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('status') }}</strong></span>
        @enderror
    </div>

    {{-- priority input --}}
    <div class="form-group offset-4 col-3">

        <label class="font-weight-bold col-form-label" >Priority</label>
        <label style="color: red" for="">*</label>
        <select name="priority" id="priority" class="form-control @error('priority') is-invalid @enderror">
            <option value="" disabled>Select Ticket Priority</option>
            @foreach($ticket->priorityOptions() as $activePriorityKey => $activePriorityValue)
                <option value="{{ $activePriorityKey }}" {{ ($ticket->priority == $activePriorityValue) ? 'selected' : ''}}>{{ $activePriorityValue }}</option>
            @endforeach
        </select>
        @error('priority')
        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('priority') }}</strong></span>
        @enderror
    </div>
</div>

<div class="row col-12">

{{--    set assignee--}}
    <div class="form-group col-3">
        <label class="font-weight-bold col-form-label" >Assignee</label>


        <select name="assigned_to" id="assigned_to" class="form-control">
            <option value="" hidden >Select Assignee</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ ($ticket->assignedUser) ?  ($user->id == $ticket->assignedUser->id  ? 'selected' : '') : '' }}>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>


    {{-- due date input --}}
    <div class="form-group offset-4  col-4">
        <label class="font-weight-bold col-form-label" for="due_date">Due Date</label>

        <input id="due_date"  name="due_date" type="date" value="{{  old('due_date') ?? ($ticket->due_date != null) ? Carbon\Carbon::parse($ticket->getOriginal('due_date'))->format('Y-m-d') : null }}" class="form-control @error('due_date') is-invalid @enderror">

        @error('due_date')
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('due_date') }}</strong></span>
        @enderror
    </div>
</div>

<div>
<input type="hidden" name="token" value=" {{$token}}">
</div>



