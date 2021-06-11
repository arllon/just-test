<?php

namespace Database\Seeders;

use App\Models\Movement;
use Illuminate\Database\Seeder;

class MovementSeeder extends Seeder
{
    const MOVEMENT_NAMES = [
        'Deadlift',
        'Back Squat',
        'Bench Press'
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (self::MOVEMENT_NAMES as $name) {
            Movement::create([
                'name' => $name
            ]);
        }
    }
}
