<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        Customer::all()->each(function (Customer $customer) {
            $count = random_int(2, 3);

            Ticket::factory()->count($count)->create([
                'customer_id' => $customer->id,
            ]);
        });
    }
}
