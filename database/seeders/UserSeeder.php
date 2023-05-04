<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder{
    public function run()
    {
        $user = new User;
        $user->name = "Arianna";
        $user->email = "hello@arianna.com";
        $user->password = "password";
        Suser->save();
    }
}