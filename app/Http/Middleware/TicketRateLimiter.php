<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketRateLimiter
{
    public function handle(Request $request, Closure $next): Response
    {
        $phone = $request->input('phone');
        $email = $request->input('email');

        $customer = Customer::query()
            ->when($phone, fn ($q) => $q->orWhere('phone', $phone))
            ->when($email, fn ($q) => $q->orWhere('email', $email))
            ->first();

        if ($customer) {
            $alreadySent = $customer->tickets()
                ->whereDate('created_at', today())
                ->exists();

            if ($alreadySent) {
                return response()->json([
                    'message' => 'Вы уже отправляли заявку сегодня. Повторная отправка возможна через 24 часа.',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return $next($request);
    }
}
