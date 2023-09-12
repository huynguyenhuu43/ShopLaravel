<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductsAttribute;
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
            $product = Product::find($id);
            $message = "Sửa sản phẩm thành công !";
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

            return view('admin.products.add_edit_product')->with(compact('title','categories','brands','product'));
    }

    public function deleteProductImage($id){
        // Get product image
                $productImage = Product::select('product_image')->where('id', $id)->first();
                // Get Product Image Paths
                $small_image_path ='front/images/product_images/small/';
                $medium_image_path = 'front/images/product_images/medium/';
                $large_image_path = 'front/images/product_images/large/';
                // Delete Product small image if exists in small folder
                if(file_exists($small_image_path.$productImage->product_image)){
                unlink($small_image_path.$productImage->product_image);
                }
                // Delete Product medium image if exists in medium folder
                if(file_exists($medium_image_path. $productImage->product_image)) {
                unlink($medium_image_path. $productImage->product_image);
                }
                // Delete Product large image if exists in large folder
                if(file_exists($large_image_path. $productImage->product_image)) {
                unlink($large_image_path. $productImage->product_image);
                }
                // Delete Product image from products table
                Product::where('id', $id)->update(['product_image' =>'']);
                $message = "Xóa hình sản phẩm thành công !";
                return redirect()->back()->with('success_message',$message);
    }

    public function deleteProductVideo($id){
        // Get Product Video
            $productVideo = Product::select('product_video')->where('id',$id)->first();
            // Get Product Video Path
            $product_video_path = 'front/videos/product_videos/';
            // Delete Product Video from product_videos folder if exists
            if(file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video);
            }
            // Delete Product Video Image from products table
            Product::where('id',$id)->update(['product_video'=>'']);
            $message = "Xóa video thành công !";
            return redirect()->back()->with('success_message', $message);
    }

    public function addAttributes(Request $request, $id){
        $product = Product::select('product_name','product_code','product_color','product_price','product_image')->with('attributes')->find($id);
        //dd($product);
        if ($request->isMethod ('post')){
            $data = $request->all();
           /// echo "<pre>"; print_r($data); die;

            foreach ($data['sku'] as $key => $value){
                if(!empty($value)){
                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1; 
                    $attribute->save();
                }
            }
            return redirect()->back()->with('success_message','Thuộc tính sản phẩm được thêm thành công !');
        }
            
        return view('admin.attributes.add_edit_attributes')->with(compact('product'));
    }
}