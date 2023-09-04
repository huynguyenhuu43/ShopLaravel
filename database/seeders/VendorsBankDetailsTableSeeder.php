<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetail;

class VendorsBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecords = [
            ['id'=>1,'vendor_id'=>1,'account_holder_name'=>'Nguyen Huu Huy','bank_name'=>'MB Bank','account_number'=>'0398730223','bank_ifsc_code'=>'161220'],
        ];
        VendorsBankDetail::insert($vendorRecords);
    }
}
