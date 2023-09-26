<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;

class IndexController extends Controller
{
    public function index(){
        $sliderBanners = Banner::where('type','Slider')->where('status',1)->get()->toArray();
        $fixBanners = Banner::where('type','Fix')->where('status',1)->get()->toArray();
        $newProducts = Product::orderBy('id','Desc')->where('status',1)->limit(8)->get()->toArray();
        $bestSeller =Product::where(['is_bestseller'=>'Yes','status'=>1])->inRandomOrder()->get()->toArray();
        $discountedProducts = Product::where('product_discount','>',0)->where('status',1)->limit(6)->inRandomOrder()->get()->toArray();
        $featuredProducts = Product::where(['is_featured'=>'Yes','status'=>1])->limit(6)->get()->toArray();
        $meta_title ="Trang web thiết bị di động đa nhà cung cấp";
        $meta_description ="Mua sắm online các thiết bị như Điện thoại, Laptop, Máy tính bảng";
        $meta_keywords ="website điện tử, mua sắm online,đa nhà cung cấp ";
        return view('front.index')->with(compact('sliderBanners','fixBanners','newProducts','bestSeller','discountedProducts','featuredProducts','meta_title','meta_description','meta_keywords'));
    }
}
