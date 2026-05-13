<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    public function definition(): array
    {
        $status = fake()->randomElement(['new', 'in_progress', 'resolved']);

        return [
            'customer_id' => Customer::factory(),
            'subject' => fake()->sentence(5),
            'body' => fake()->paragraph(3),
            'status' => $status,
            'replied_at' => $status === 'resolved'
                ? fake()->dateTimeBetween('-1 month', 'now')
                : null,
        ];
    }
}
