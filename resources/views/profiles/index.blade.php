@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 pt-5 pl-5">
{{--            <img src="{{ $user->profile->profileImage() }}" alt="" class="rounded-circle w-100">--}}
        </div>
        <div class="col-9 pt-5 pl-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-3">
                    <div class="h1">{{ $user->name }}</div>
                 </div>

{{--                @can('update', $user->profile)--}}
{{--                    <a href="/p/create">Add new post</a>--}}
{{--                @endcan--}}

            </div>
{{--            @can('update', $user->profile)--}}
{{--                <a href="/profile/{{$user->id}}/edit">Edit Profile</a>--}}
{{--            @endcan--}}

{{--            <div class="d-flex">--}}
{{--                <div class="pr-5"><strong>{{ $postCount }}</strong> posts</div>--}}
{{--                <div class="pr-5"><strong>{{ $followersCount }}</strong> followers</div>--}}
{{--                <div class="pr-5"><strong>{{ $followingCount }}</strong> following</div>--}}
{{--            </div>--}}
            <div class="pt-4 font-weight-bold">{{$user->profile->title}} </div>
            <div><a href="#">{{$user->email}}</a></div>
        </div>
    </div>


    <div class="row pt-5">
{{--        @foreach($user->posts as $post)--}}
{{--            <div class="col-4 pb-4">--}}
{{--                <a href="/p/{{ $post->id }}"><img src="/storage/{{ $post->image }}" class="img-fluid"></a>--}}

{{--            </div>--}}
{{--        @endforeach--}}
    </div>
</div>
@endsection
