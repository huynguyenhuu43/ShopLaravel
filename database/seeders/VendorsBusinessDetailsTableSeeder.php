<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetail;

class VendorsBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecords = [
            ['id'=>1,'vendor_id'=>1,'shop_name'=>'Huy Mobile Store','shop_address'=>'755 Nguyễn Kiệm','shop_city'=>'Hổ Chí Minh','shop_state'=>'Gò Vấp','shop_country'=>'Việt Nam','shop_zipcode'=>'71409','shop_mobile'=>'0398730223','shop_website'=>'https://www.facebook.com/huyhuyhuy.qq','shop_email'=>'huy@admin.com','address_proof'=>'Passport','address_proof_image'=>'test.jpg','business_license_number'=>'9967152','gst_number'=>'1231211','pan-number'=>'4647531'],
        ];
        VendorsBusinessDetail::insert($vendorRecords);
    }
}
