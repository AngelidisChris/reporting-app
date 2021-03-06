<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Psy\Util\Json;

class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $tickets = Ticket::sortable()->orderBy('created_at', 'desc')->get();

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $ticket = new Ticket();

        $users = User::all();
//      Prevent double submit -- generate a random token and storing it in a session AND a hidden field.
//      If it doesnt match, reject the form, if it does match, accept the form and nuke the session key.
        $token = Str::random(16);
        session(['token' => $token]);


        return view('tickets.create', compact('ticket', 'token', 'users'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {


//        check if session token and hidden field are equal. If yes, nuke session var, else double submit
        if (session()->has('token') && $request['token'] == session()->get('token'))
            session()->remove('token');
        else
            return redirect('/tickets');

//        create new ticket if the input validation passes
        $data = $this->validateCreateRequest();


        $ticket = auth()->user()->tickets()->create([
            'title' => $data['title'],
            'body' => $data['body'],
            'status' => $data['status'],
            'priority' => $data['priority'],
            'due_date' => $data['due_date'],
            'tracker' => $data['tracker'],
            'assigned_to' => $data['assigned_to']
        ]);


//        auth()->user()->tickets()->create(
//            $this->validateRequest()
//            );

        return redirect('/tickets')->with('create-message', 'Ticket #' . str_pad($ticket->id, 3, '0', STR_PAD_LEFT) . ' successfully created.');;
    }

    /**
     * Display the specified resource.
     *
     * @param Ticket $ticket
     * @return View
     */
    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ticket $ticket
     * @return View
     */
    public function edit(Ticket $ticket)
    {
//      Prevent double submit -- generate a random token and storing it in a session AND a hidden field.
//      If it doesnt match, reject the form, if it does match, accept the form and nuke the session key.
        $token = Str::random(16);
        $users = User::all();

        session(['token' => $token]);

        return view('tickets.edit', compact('ticket', 'token', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function update(Ticket $ticket)
    {
        //        check if session token and hidden field are equal. If yes, nuke session var, else double submit
        if (session()->has('token') && \request()['token'] == session()->get('token'))
            session()->remove('token');
        else
            return redirect('/tickets');

        $ticket->update($this->validateUpdateRequest());

        return redirect('tickets/' . $ticket->id)->with('message', 'Successful update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ticket $ticket
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Ticket $ticket)
    {
        try {
            $ticket->delete();
        } catch (\Exception $e) {

        }
        return redirect('/tickets')->with('message', 'Ticket #' . str_pad($ticket->id, 3, '0', STR_PAD_LEFT) . ' was deleted.');
    }

    private function validateCreateRequest()
    {
        return (\request()->validate([
            'title' => 'required|max:300',
            'body' => 'required|max:10000',
            'priority' => 'required|integer',
            'due_date' => 'date|after_or_equal:today|nullable',
            'tracker' => 'required|integer',
            'status' => 'required|integer',
            'assigned_to' => 'sometimes|integer|nullable',
        ]));
    }

    private function validateUpdateRequest()
    {
        return (\request()->validate([
            'comment' => 'required|string|max:10000',
            'priority' => 'required|integer',
            'due_date' => 'date|after_or_equal:today|nullable',
            'tracker' => 'required|integer',
            'status' => 'required|integer',
            'assigned_to' => 'sometimes|integer|nullable',
        ]));
    }

    /**
     * Use when we delete ticket assignee from show view
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeAssignee()
    {
        $ticket = Ticket::find(\request('id'));
        $ticket->update(['assigned_to' => null]);
        return response()->json('');
    }

}
