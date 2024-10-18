<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class GstMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gst_masters')->insert([
        [
         'name' => 'Gst 5%', 
         'value' => '5',     
         'status'=>'1',
         'created_at' => now(),
         'updated_at' => now(),
        ],
        [
         'name' => 'Gst 12%', 
         'value' => '12',     
         'status'=>'1',
         'created_at' => now(),
         'updated_at' => now(),
        ],
        [
         'name' => 'Gst 18%', 
         'value' => '18',     
         'status'=>'1',
         'created_at' => now(),
         'updated_at' => now(),
        ]
        ]);
    }
}
