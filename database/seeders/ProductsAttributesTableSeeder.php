<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsAttribute;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productAttributesRecords =[
            ['id'=>1,'product_id'=>12,'size'=>'Small','price'=>1000,'stock'=>10,'sku'=>'RCS1200','status'=>1],
            ['id'=>2,'product_id'=>12,'size'=>'Medium','price'=>2222,'stock'=>15,'sku'=>'RCS1300','status'=>1],
            ['id'=>3,'product_id'=>12,'size'=>'Latge','price'=>3333,'stock'=>22,'sku'=>'RCS1100','status'=>1],
        ];
        ProductsAttribute::insert($productAttributesRecords);
    }
}
