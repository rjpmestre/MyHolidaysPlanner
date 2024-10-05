<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vacation;

class VacationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Vacation::Create(['date' => '2025-04-21']);
        Vacation::Create(['date' => '2025-04-22']);
        Vacation::Create(['date' => '2025-04-23']);
        Vacation::Create(['date' => '2025-04-24']);
        Vacation::Create(['date' => '2025-04-28']);
        Vacation::Create(['date' => '2025-04-29']);
        Vacation::Create(['date' => '2025-04-30']);
        Vacation::Create(['date' => '2025-05-02']);
        Vacation::Create(['date' => '2025-06-09']);
        Vacation::Create(['date' => '2025-06-09']);
        Vacation::Create(['date' => '2025-06-11']);
        Vacation::Create(['date' => '2025-06-12']);
        Vacation::Create(['date' => '2025-06-20']);
        Vacation::Create(['date' => '2025-08-11']);
        Vacation::Create(['date' => '2025-08-12']);
        Vacation::Create(['date' => '2025-08-13']);
        Vacation::Create(['date' => '2025-08-14']);
        Vacation::Create(['date' => '2025-08-18']);
        Vacation::Create(['date' => '2025-08-19']);
        Vacation::Create(['date' => '2025-08-20']);
        Vacation::Create(['date' => '2025-08-21']);
        Vacation::Create(['date' => '2025-08-22']);
    }
}
