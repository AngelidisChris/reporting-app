<?php

namespace App\Policies;

use App\Ticket;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use phpDocumentor\Reflection\Types\Boolean;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tickets.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function view(User $user, Ticket $ticket)
    {
        //
    }

    /**
     * Determine whether the user can create tickets.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return Bool
     */
    public function update(User $user, Ticket $ticket)
    {
        return $ticket->user_id == $user->id || $ticket->assigned_to == $user->id;
    }

    /**
     * Determine whether the user can delete the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return Bool
     */
    public function delete(User $user, Ticket $ticket)
    {
        return $ticket->user_id == $user->id || $ticket->assigned_to == $user->id;
    }

    /**
     * Determine whether the user can remove ticket assignee.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return Bool
     */
    public function removeAssignee(User $user, Ticket $ticket)
    {
        return $ticket->user_id == $user->id || $ticket->assigned_to == $user->id;
    }

    /**
     * Determine whether the user can restore the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function restore(User $user, Ticket $ticket)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function forceDelete(User $user, Ticket $ticket)
    {
        //
    }
}
