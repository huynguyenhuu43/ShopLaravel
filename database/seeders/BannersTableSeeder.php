<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bannerRecords =[
            ['id'=>1,'image'=>'banner1.webp','link'=>'spring1-collection','title'=>'Spring1','alt'=>'Spring1','status'=>1],
            ['id'=>2,'image'=>'banner2.webp','link'=>'spring2-collection','title'=>'Spring2','alt'=>'Spring2','status'=>1],
            ['id'=>3,'image'=>'banner3.webp','link'=>'spring3-collection','title'=>'Spring3','alt'=>'Spring3','status'=>1],
            ['id'=>4,'image'=>'banner4.webp','link'=>'spring4-collection','title'=>'Spring4','alt'=>'Spring4','status'=>1]
        ];
        Banner::insert($bannerRecords);
    }
}
