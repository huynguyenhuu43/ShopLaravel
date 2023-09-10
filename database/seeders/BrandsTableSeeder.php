<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandRecords = [
        ['id'=>1,'name'=>'Arrow','status'=>1],
        ['id'=>2,'name'=>'Samsung','status'=>1],
        ['id'=>3,'name'=>'Apple','status'=>1],
        ['id'=>4,'name'=>'Lenovo','status'=>1],
        ['id'=>5,'name'=>'Asus','status'=>1],
        ['id'=>6,'name'=>'Acer','status'=>1],
        ['id'=>7,'name'=>'MI','status'=>1]
        ];
        Brand::insert($brandRecords);
    }
}
