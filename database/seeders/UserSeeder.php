<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'first_name' => 'Diosdado',
                'last_name' => 'Banatao',
                'middle_name' => 'P.',
                'email' => 'diosdado.banatao@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Joey',
                'last_name' => 'Gurango',
                'middle_name' => '',
                'email' => 'joey.gurango@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Leandro',
                'last_name' => 'Leviste',
                'middle_name' => '',
                'email' => 'leandro.leviste@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Winston',
                'last_name' => 'Damarillo',
                'middle_name' => '',
                'email' => 'winston.damarillo@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Michie',
                'last_name' => 'Calica',
                'middle_name' => '',
                'email' => 'michie.calica@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Paul',
                'last_name' => 'Rivera',
                'middle_name' => '',
                'email' => 'paul.rivera@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Ngo',
                'middle_name' => '',
                'email' => 'john.ngo@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Ressa',
                'middle_name' => 'A.',
                'email' => 'maria.ressa@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Dado',
                'last_name' => 'Banatao',
                'middle_name' => '',
                'email' => 'dado.banatao@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Chris',
                'last_name' => 'Great',
                'middle_name' => '',
                'email' => 'chris.great@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        ]);
    }
}
