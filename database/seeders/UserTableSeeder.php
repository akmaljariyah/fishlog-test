<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate([
            'nama' => 'Franasahrul Akmal',
            'email' => 'franasahrul.akmal@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
