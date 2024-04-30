<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    //create user admin
    User::create([
        'name' => 'Admin',
        'email' => 'admin@admin.com',
        'password' => Hash::make('123456'),
        'grant_role' => 'full_control'
    ]);


    }
}
