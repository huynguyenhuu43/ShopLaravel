<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRecords = [
            ['id'=>2,'name'=>'Huy','type'=>'vendor','vendor_id'=>1,'mobile'=>'0398730223','email'=>'huy@admin.com','password'=>'$2a$12$W5w2s5V9cIUD5TcoVsH9uOqIQmL0gDTAWA0V8g2xHycXGB3WkWnj2','image'=>'','status'=>0],  
        ];
        Admin::insert($adminRecords);
    }
}
