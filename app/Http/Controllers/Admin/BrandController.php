<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Session;

class BrandController extends Controller
{
    public function brands(){
    Session::put('page','brands');
        $brands = Brand::get()->toArray();
        //dd($brands);
        return view('admin.brands.brands')->with(compact('brands'));
    }

    public function updateBrandStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Brand::where('id',$data['brand_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'brand_id'=>$data['brand_id']]);
        }
    }

    public function deleteBrand($id){
        Brand::where('id',$id)->delete();
        $message = "Thương hiệu đã được xóa";
        return redirect()->back()->with('success_message',$message);
    }

    public function addEditBrand(Request $request,$id=null){
        Session::put('page','brands');
        if($id==""){
            $title ="Thêm thương hiệu";
            $brand = new Brand;
            $message = "Thương hiệu được thêm thành công !";
        }else{
            $title ="Sửa thương hiệu";
            $brand = Brand::find($id);
            $message = "Thương hiệu được cập nhật thành công !";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $rules = [
                'brand_name'=> 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessages =[
                'brand_name.required'=> 'Bạn phải nhập tên thương hiệu !',
                'brand_name.regex'=> 'Tên thương hiệu không hợp lệ !',
            ];

            $this->validate($request,$rules,$customMessages);
            $brand->name =$data['brand_name'];
            $brand->status =1;
            $brand->save();
            return redirect('admin/brands')->with('success_message',$message);
        }
        return view('admin.brands.add_edit_brand')->with(compact('title','brand'));
    }
}
