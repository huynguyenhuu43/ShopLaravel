<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsFilter;

class FiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //1,2,3,6,13,15
        $filterRecords =[
            ['id'=>1,'cat_ids'=>'1,2,3,6,13,15','filter_name'=>'Fabric','filter_column'=>'fabric','status'=>1],
            ['id'=>2,'cat_ids'=>'7,8,14','filter_name'=>'RAM','filter_column'=>'ram','status'=>1]
        ];
        ProductsFilter::insert($filterRecords);
    }
}
