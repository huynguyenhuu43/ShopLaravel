<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\ProductsFilter;

class ProductsController extends Controller
{
    public function listing(Request $request){
        if($request->ajax()){
            $data =$request->all();
            //echo "<pre>"; print_r($data); die;

            $url = $data['url'];
            $_GET['sort']=$data['sort'];
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){
                $categoryDetails = Category::categoryDetails($url);
                //
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
                
                //check for Fabric
                $productFilters = ProductsFilter::productFilters();
                foreach ($productFilters as $key => $filter){
                    if(isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && !empty($filter['filter_column']) && !empty($data[$filter['filter_column']])){
                        $categoryProducts->whereIn($filter['filter_column'],$data[$filter['filter_column']]);
                    }
                }
                
                //check sort
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="product_latest"){
                        $categoryProducts->orderby('products.id','Desc');
                    }else if($_GET['sort']=="price_lowest"){
                        $categoryProducts->orderby('products.product_price','Asc');
                    }else if($_GET['sort']=="price_highest"){
                        $categoryProducts->orderby('products.product_price','Desc');
                    }else if($_GET['sort']=="name_a_z"){
                        $categoryProducts->orderby('products.product_name','Asc');
                    }else if($_GET['sort']=="name_z_a"){
                        $categoryProducts->orderby('products.product_name','Desc');
                    }
                }

                //check for size
                if(isset($data['size']) && !empty($data['size'])){
                    $productIds =ProductsAttribute::select('product_id')->whereIn('size',$data['size'])->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                //check for color
                if(isset($data['color']) && !empty($data['color'])){
                    $productIds = Product::select('id')->whereIn('product_color',$data['color'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                //check for price
                if(isset($data['price']) && !empty($data['price'])){
                    foreach ($data['price'] as $key =>$price){
                        $priceArr = explode("-",$price);
                        $productIds[]= Product::select('id')->whereBetween('product_price',[$priceArr[0],$priceArr[1]])->pluck('id')->toArray();
                    }
                    $productIds = call_user_func_array('array_merge',$productIds);
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                //check for brand
                if(isset($data['brand']) && !empty($data['brand'])){
                    $productIds = Product::select('id')->whereIn('brand_id',$data['brand'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                $categoryProducts= $categoryProducts->paginate(15);
                //dd($categoryDetails);
                // echo "Category exists"; die;
                return view('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{
                abort(404);
            }
        }else{
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){
                $categoryDetails = Category::categoryDetails($url);
                //
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
                
                //check sort
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="product_latest"){
                        $categoryProducts->orderby('products.id','Desc');
                    }else if($_GET['sort']=="price_lowest"){
                        $categoryProducts->orderby('products.product_price','Asc');
                    }else if($_GET['sort']=="price_highest"){
                        $categoryProducts->orderby('products.product_price','Desc');
                    }else if($_GET['sort']=="name_a_z"){
                        $categoryProducts->orderby('products.product_name','Asc');
                    }else if($_GET['sort']=="name_z_a"){
                        $categoryProducts->orderby('products.product_name','Desc');
                    }
                }
                $categoryProducts= $categoryProducts->paginate(15);
                //dd($categoryDetails);
                // echo "Category exists"; die;
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{
                abort(404);
            }
        }
       
    }
}
