<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
         'name' => 'admin',  
         'email' => 'admin@admin.com',  
         'mobile' => '1234567890', 
         'image' => '',
         'password' => Hash::make('password'),
         'role_id'=>'1',
         'remember_token' => Str::random(10),
         'status'=>'1', 
         'created_at' => now(),
         'updated_at' => now(),
        ]);
    }
}
