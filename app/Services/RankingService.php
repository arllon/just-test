<?php

namespace App\Services;

use App\Models\Movement;
use App\Models\PersonalRecord;

class RankingService
{
    /**
     * Return a user ranking by movement
     *
     * @return array
     */
    public function getUserRankingByMovement(int $movementId): array
    {
        Movement::findOrFail($movementId);

        $ranking = [];
        
        $personalDataRecords = PersonalRecord::query()
            ->with(['user', 'movement'])
            ->selectRaw('MAX(value) as value, user_id, movement_id, date')
            ->where('movement_id', $movementId)
            ->orderBy('value', 'DESC')
            ->groupBy(['user_id', 'movement_id'])
            ->get();

        $position = 1;
        $bestValue = null;
        foreach ($personalDataRecords as $personalDataRecord) {
            $ranking[] = [
                'value' => $personalDataRecord->value,
                'user' => $personalDataRecord->user->name,
                'movement' => $personalDataRecord->movement->name,
                'date' => $personalDataRecord->date,
                'position' => !$bestValue || $personalDataRecord->value === $bestValue ? $position : $position = $position + 1
            ];

            $bestValue = $personalDataRecord->value;
        }

        return $ranking;
    }
}
