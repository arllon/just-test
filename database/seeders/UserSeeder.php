<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    const USER_NAMES = [
        'João',
        'Jose',
        'Paulo'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (self::USER_NAMES as $name) {
            User::create([
                'name' => $name
            ]);
        }
    }
}
