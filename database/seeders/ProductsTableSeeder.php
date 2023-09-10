<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productRecords =[
            ['id'=>1,'section_id'=>1,'category_id'=>6,'brand_id'=>8,'vendor_id'=>1,'admin_id'=>0,'admin_type'=>'vendor','product_name'=>'Redmi Note 11','product_code'=>'RN11','product_color'=>'Blue','product_price'=>'5000000','product_discount'=>10,'product_weight'=>'500','product_image'=>'','product_video'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'Yes','status'=>1],
            ['id'=>2,'section_id'=>7,'category_id'=>7,'brand_id'=>5,'vendor_id'=>0,'admin_id'=>1,'admin_type'=>'admin','product_name'=>'Asus 128GB','product_code'=>'AS11','product_color'=>'Blue','product_price'=>'15000000','product_discount'=>10,'product_weight'=>'1500','product_image'=>'','product_video'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'Yes','status'=>1]
        ];
        Product::insert($productRecords);
    }
}
