<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecords = [
            ['id'=>1,'name'=>'Huy','address'=>'755-NK','city'=>'HCM','state'=>'Govap','country'=>'VietNam','zipcode'=>'71409','mobile'=>'0398730223','email'=>'huy@admin.com','status'=>0],
        ];
        Vendor::insert($vendorRecords);
    }
}
