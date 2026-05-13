<?php

namespace App\Services;

use App\Models\Ticket;

class StatisticsService
{
    public function getStatistics(): array
    {
        return [
            'today' => Ticket::createdToday()->count(),
            'week' => Ticket::createdThisWeek()->count(),
            'month' => Ticket::createdThisMonth()->count(),
            'by_status' => Ticket::query()
                ->selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status'),
        ];
    }
}
