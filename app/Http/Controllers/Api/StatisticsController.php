<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketStatisticsResource;
use App\Services\StatisticsService;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    public function __construct(private readonly StatisticsService $statisticsService)
    {
    }

    public function index(): JsonResponse
    {
        $stats = $this->statisticsService->getStatistics();

        return (new TicketStatisticsResource($stats))->response();
    }
}
