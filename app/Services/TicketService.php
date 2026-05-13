<?php

namespace App\Services;

use App\Http\Requests\Api\StoreTicketRequest;
use App\Models\Customer;
use App\Models\Ticket;

class TicketService
{
    public function createTicket(StoreTicketRequest $request): Ticket
    {
        $customer = Customer::updateOrCreate(
            ['phone' => $request->input('phone')],
            [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ]
        );

        $ticket = $customer->tickets()->create([
            'subject' => $request->input('subject'),
            'body' => $request->input('body'),
            'status' => 'new',
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $ticket->addMedia($file)->toMediaCollection('attachments');
            }
        }

        return $ticket->load('customer');
    }
}
