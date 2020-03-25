<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Test";
        $user->email = "test@test.com";
        $user->password = Hash::make('secret');
        $user->is_admin = true;
        $user->save();
    }
}
