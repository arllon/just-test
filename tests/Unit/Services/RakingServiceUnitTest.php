<?php

use App\Models\Movement;
use App\Models\PersonalRecord;
use App\Services\RankingService;
use Illuminate\Http\Response;

class RankingServiceUnitTest extends TestCase
{
    private $service;
    
    public function setUp(): void
    {
        $this->service = app(RankingService::class);
        parent::setUp();
    }

    public function testSuccessResponseWithValidMovement(): void
    {
        $movement = PersonalRecord::all()->first()->movement;
        
        $response = $this->service->getUserRankingByMovement($movement->id);
        $expectedKeys = [
            'position',
            'user',
            'movement',
            'date',
            'value'
        ];

        $this->assertIsArray($response);

        foreach ($expectedKeys as $key) {
            $this->assertTrue(isset($response[0][$key]));
        }
    }

    public function testWithInvalidMovement(): void
    {
        $fakeMovementId = 99;
        $this->expectExceptionMessage("No query results for model [App\Models\Movement] {$fakeMovementId}");
        
        $this->service->getUserRankingByMovement($fakeMovementId);
    }

    public function testSuccessResponseIfMovementWithoutPersonalRecords(): void
    {
        $movementsWithPersonalRecord = PersonalRecord::all()
            ->pluck('movement_id')
            ->toArray();

        $movement = Movement::whereNotIn('id', $movementsWithPersonalRecord)->first();
          
        $response = $this->service->getUserRankingByMovement($movement->id);

        $this->assertIsArray($response);
        $this->assertEmpty($response);
    }
}
