<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Ticket::class);

        $tickets = Ticket::with('customer')
            ->when($request->input('status'), fn ($q, $status) => $q->where('status', $status))
            ->when($request->input('email'), fn ($q, $email) => $q->whereHas(
                'customer',
                fn ($cq) => $cq->where('email', 'like', "%{$email}%")
            ))
            ->when($request->input('phone'), fn ($q, $phone) => $q->whereHas(
                'customer',
                fn ($cq) => $cq->where('phone', 'like', "%{$phone}%")
            ))
            ->when($request->input('date_from'), fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
            ->when($request->input('date_to'), fn ($q, $date) => $q->whereDate('created_at', '<=', $date))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket): View
    {
        $this->authorize('view', $ticket);

        $ticket->load('customer');

        $files = $ticket->getMedia('attachments');

        return view('admin.tickets.show', compact('ticket', 'files'));
    }

    public function updateStatus(Request $request, Ticket $ticket): RedirectResponse
    {
        $this->authorize('updateStatus', $ticket);

        $request->validate([
            'status' => ['required', 'in:new,in_progress,resolved'],
        ]);

        $ticket->update([
            'status' => $request->input('status'),
            'replied_at' => $request->input('status') === 'resolved' ? now() : $ticket->replied_at,
        ]);

        return redirect()
            ->route('admin.tickets.show', $ticket)
            ->with('success', 'Статус заявки обновлён.');
    }
}
