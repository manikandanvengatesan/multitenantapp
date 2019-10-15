<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schools')->insert([
            'name' => "cloud",
            'email' => 'cloud@school.com',
            'address' => 'India',
            'phone' =>'0987654321',
        ]);

        DB::table('users')->insert([
            'name' => "School",
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'school_id' =>1,
        ]);
    }
}
