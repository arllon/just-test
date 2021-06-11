<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Services\RankingService;
use Illuminate\Http\JsonResponse;

class RankingController extends Controller
{
    private $rankingService;

    public function __construct(RankingService $rankingService)
    {
        $this->rankingService = $rankingService;
    }

    /**
     * Return a user ranking by movement
     *
     * @param int $movementId
     * @return JsonResponse
     */
    public function getUserRankingByMovement(int $movementId): JsonResponse
    {
        $data = $this->rankingService->getUserRankingByMovement($movementId);

        return response()->json($data);
    }
}
