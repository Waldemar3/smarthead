<?php

use App\Http\Controllers\Api\StatisticsController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Middleware\TicketRateLimiter;
use Illuminate\Support\Facades\Route;

Route::post('/tickets', [TicketController::class, 'store'])
    ->middleware(TicketRateLimiter::class);

Route::get('/tickets/statistics', [StatisticsController::class, 'index']);
