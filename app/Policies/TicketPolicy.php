<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'manager']);
    }

    public function view(User $user, Ticket $ticket): bool
    {
        return $user->hasAnyRole(['admin', 'manager']);
    }

    public function updateStatus(User $user, Ticket $ticket): bool
    {
        return $user->hasAnyRole(['admin', 'manager']);
    }
}
