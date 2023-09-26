<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $couponRecords =[
            ['id'=>1,'vendor_id'=>0,'coupon_option'=>'Manual','coupon_code'=>'test1','categories'=>'1','users'=>'','coupon_type'=>'Single','amount_type'=>'Percentage','amount'=>10,'expiry_date'=>'2023-09-20','status'=>1],
            ['id'=>2,'vendor_id'=>17,'coupon_option'=>'Manual','coupon_code'=>'test2','categories'=>'1','users'=>'','coupon_type'=>'Single','amount_type'=>'Percentage','amount'=>20,'expiry_date'=>'2023-09-20','status'=>1]
        ];
        Coupon::insert($couponRecords);
    }
}
