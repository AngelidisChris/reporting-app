@extends('layouts.app')

@section('content')
    <form action="/profile/{{ $user->id }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PATCH')
        <div class="row">
            <h1>Edit ticket</h1>
        </div>
        <hr>
        <div class="form-group col-sm-12 col-md-6 margin-row">
            <label for="title" class="font-weight-bold col-form-label">Title</label>
            <input id="title"
                   type="text"
                   class="form-control @error('title') is-invalid @enderror"
                   name="title" value="{{ old('title') ?? $user->profile->title}}"
                   autocomplete="on" autofocus>

            @error('title')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group col-sm-12 col-md-6 margin-row">
            <label for="email" class="font-weight-bold col-form-label">Email</label>
            <input id="email"
                   type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') ?? $user->email}}"
                   autocomplete="on" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group col-sm-12 col-md-6 margin-row">
            <label for="image" class="font-weight-bold col-form-label">Profile Image</label>
            <input type="file" class="form-control-file" id="image" name="image">

            @error('image')
            <strong style="color: red">{{ $message }}</strong>
            @enderror
        </div>

        <div class="d-flex justify-content-center pt-3">
            <button class="col-md-3 btn btn-primary">Save Profile</button>
        </div>

        @csrf
    </form>
@endsection
