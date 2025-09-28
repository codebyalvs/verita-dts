<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('counters')->insert([
            [
                'name' => 'Logins',
                'value' => 0,
            ],
            [
                'name' => 'Registrations',
                'value' => 0,
            ],
            [
                'name' => 'Page Views',
                'value' => 0,
            ],
        ]);
    }
}
