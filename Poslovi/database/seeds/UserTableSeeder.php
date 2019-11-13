<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // This is admin-moderator.
        User::create([
            'email' => 'pera@gmail.com',
            'password' => Hash::make('admin123'),
            'name' => 'pera',
            'role_id' => 2 
        ]);


        // This is normal user
        User::create([
            'email' => 'pera1@gmail.com',
            'password' => Hash::make('admin123'),
            'name' => 'pera',
            'role_id' => 1
        ]);
    }
}
