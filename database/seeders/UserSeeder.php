<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'Administrator Apotek',
        //     'email' => 'Administrator@gmail.com',
        //     'password' => Hash::make('adminapotek'),
        //     'role' => 'admin'
        // ]);

        User::create([
            'name' => 'Kasir Apotek',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('kasir'),
            'role' => 'cashier'
        ]);

    }

}
