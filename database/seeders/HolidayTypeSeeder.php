<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HolidayType;

class HolidayTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HolidayType::create(['id'=> 1,'name' => 'Nacionais']);
        HolidayType::create(['id'=> 2,'name' => 'Empresa']);
    }
}
