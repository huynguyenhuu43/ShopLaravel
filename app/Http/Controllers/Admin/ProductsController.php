<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Auth;
use Image;

class ProductsController extends Controller
{
    public function products(){
        $products = Product::with(['section'=>function($query){
            $query->select('id','name');
        },'category'=>function($query){
            $query->select('id','category_name');
        }])->get()->toArray();
        //dd($products);
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
        }
    }

    public function deleteProduct($id){
        //delete category
        Product::where('id',$id)->delete();
        $message = "Xóa sản phẩm thành công !";
        return redirect()->back()->with('success_message',$message);
    }

    public function addEditProduct(Request $request,$id=null){
        if($id==""){
            $title = "Thêm sản phẩm";
            $product = new Product;
            $message = "Thêm sản phẩm thành công !";
        }else{
            $title = "Sửa sản phẩm";
        }
        if($request->isMethod('post')){
            $data =$request->all();
           // echo "<pre>"; print_r(Auth::guard('admin')->user()); die;

            $rules = [
                'category_id'=> 'required',
                //'product_name'=> 'required|regex:/^[\pL\s\-]+$/u',
                'product_code'=> 'required|regex:/^\w+$/',
                'product_price'=> 'required|numeric',
                'product_color'=> 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessages =[
                'category_id.required'=>'Category is required',
                'product_name.required' => 'Product Name is required',
                //'product_name.regex' => 'Valid Product Name is required',
                'product_code.required' => 'Product Code is required',
                'product_code.regex' => 'Valid Product Code is required',
                'product_price.required'=> 'Product Price is required',
                'product_price.numeric' => 'Valid Product Price is required',
                'product_color.required' => 'Product Color is required',
                'product_color.regex' => 'Valid Product Color is required',
            ];

            $this->validate($request,$rules,$customMessages);

            //up hình small: 250x250 500x500 1000x1000
            if($request->hasFile('product_image')){
                $image_tmp = $request->file('product_image');
                if($image_tmp->isValid()) {
                //Upload Image after Resize
                //get image extension
                $extension = $image_tmp->getClientOriginalExtension();

                $imageName = rand(111,99999).'.'.$extension;
                $largeImagePath = 'front/images/product_images/large/'.$imageName;
                $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                $smallImagePath = 'front/images/product_images/small/'.$imageName;

                Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath);
                Image::make($image_tmp)->resize(500,500)->save($mediumImagePath);
                Image::make($image_tmp)->resize(250,250)->save($smallImagePath);

                $product->product_image =$imageName;
            }
        }

        //upvideo
        if($request->hasFile('product_video')){
            $video_tmp = $request->file('product_video');
            if ($video_tmp->isValid()){
            // Upload Video in videos folder
        
            $extension =  $video_tmp->getClientOriginalExtension();
            $videoName = rand(111,99999).'.'.$extension;
            $videoPath = 'front/videos/product_videos/';
            $video_tmp->move($videoPath,$videoName);
            // Insert Video name in products table
            $product->product_video= $videoName;
            }
            }

             //luu
                $categoryDetails = Category::find($data['category_id']);
                $product->section_id =$categoryDetails['section_id'];
                $product->category_id =$data['category_id'];
                $product->brand_id =$data['brand_id'];

                $adminType = Auth::guard('admin')->user()->type;
                $vendor_id = Auth::guard('admin')->user()->vendor_id;
                $admin_id = Auth::guard('admin')->user()->id;

                $product->admin_type = $adminType;
                $product->admin_id = $admin_id;
                if($adminType=="vendor"){
                    $product->vendor_id = $vendor_id;
                }else{
                    $product->vendor_id = 0;
                }

                $product->product_name = $data['product_name'];
                $product->product_code = $data['product_code'];
                $product->product_color = $data['product_color'];
                $product->product_price = $data['product_price'];
                $product->product_discount = $data['product_discount'];
                $product->product_weight = $data['product_weight'];
                $product->description = $data['description'];
                $product->meta_title = $data['meta_title'];
                $product->meta_description = $data['meta_description'];
                $product->meta_keywords = $data['meta_keywords'];
                if(!empty($data['is_featured'])){
                    $product->is_featured =$data['is_featured'];
                }else{
                    $product->is_featured ="No";
                }
                $product->status = 1;
                $product->save();
                return redirect('admin/products')->with('success_message',$message);

                

                
        }

       

        //set section
        $categories = Section::with('categories')->get()->toArray();
        //dd($categories);

        //get all brand
        $brands = Brand::where('status',1)->get()->toArray();

            return view('admin.products.add_edit_product')->with(compact('title','categories','brands'));
    }
}
