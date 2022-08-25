<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'superadmin',
            'email' => 'doctor@kcsitglobal.com',
            'password' => Hash::make('medicine'),
            'is_admin' => '1',
            'approve' =>'T',
            'status' => 'Active',
        ]);
    }
}