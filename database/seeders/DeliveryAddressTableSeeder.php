<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryAddress;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deliveryRecords = [
            ['id'=>1,'user_id'=>1,'name'=>'Huy','address'=>'755-nk','city'=>'HCM','state'=>'Go Vap','country'=>'Viet Nam','zipcode'=>'99675','mobile'=>'909999999922','status'=>1],
            ['id'=>2,'user_id'=>1,'name'=>'Huy Hoang','address'=>'755-cmt8','city'=>'HN','state'=>'Thuong Tin','country'=>'Viet Nam','zipcode'=>'99655','mobile'=>'909999998922','status'=>1]
        ];
        DeliveryAddress::insert($deliveryRecords);
    }
}
