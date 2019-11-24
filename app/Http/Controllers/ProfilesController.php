<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(User $user)
    {

        $ticketsCreated = $user->tickets;
        $ticketsAssigned = $user->assignedTickets;


        $ticketsCreatedCount = $user->tickets()->count();

        $ticketsAssignedCount = $user->assignedTickets()->count();

        return view('profiles.index', compact('user','ticketsCreatedCount', 'ticketsAssignedCount', 'ticketsCreated', 'ticketsAssigned'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = \request()->validate([
            'title' => 'required',
            'email' => 'email',
            'image' => 'image'
        ]);


        if (\request('image'))
        {
            $imagePath = request('image')->store('profile', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            $imageArray = ['image' => $imagePath];

        }


        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));

        return redirect("/profile/{$user->id}");
    }
}
