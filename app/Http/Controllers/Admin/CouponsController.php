<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Brand;
use App\Models\Section;
use Illuminate\Http\Request;
use Session;
use Auth;

class CouponsController extends Controller
{
    public function coupons(){
        Session::put('page','coupons');
        $adminType =Auth::guard('admin')->user()->type;
        $vendor_id =Auth::guard('admin')->user()->vendor_id;
        if($adminType=="vendor"){
            $vendorStatus = Auth::guard('admin')->user()->status;
            if($vendorStatus==0){
                return redirect("admin/update-vendor-details/personal")->with('error_message','Tài khoản của bạn chưa được cấp phép, vui lòng liên hệ quản trị viên');
            }
            $coupons = Coupon::where('vendor_id',$vendor_id)->get()->toArray();
        }else{
            $coupons = Coupon::get()->toArray();
        }
        
        //dd($coupons);
        return view('admin.coupons.coupons')->with(compact('coupons'));
    }

    public function updateCouponStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Coupon::where('id',$data['coupon_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'coupon_id'=>$data['coupon_id']]);
        }
    }

    public function deleteCoupon($id){
        Coupon::where('id',$id)->delete();
        $message = "Thương hiệu đã được xóa";
        return redirect()->back()->with('success_message',$message);
    }

    public function addEditCoupon(Request $request,$id=null){
        if($id==""){
            //add coupon
            $title =" Thêm mã giảm giá";
            $coupon = new Coupon;
            $selCats =array();
            $selBrands =array();
            $selUsers =array();
            $message ="Thêm mã giảm giá thành công !";
        }else{
            //update coupon
            $title =" Sửa mã giảm giá";
            $coupon = Coupon::find($id);
            $selCats =explode(',',$coupon['categories']);
            $selBrands =explode(',',$coupon['brands']);
            $selUsers =explode(',',$coupon['users']);
            $message ="Sửa mã giảm giá thành công !";
        }

        if($request->isMethod('POST')){
            $data = $request->all();
           // echo "<pre>"; print_r($data); die;

            if(isset($data['categories'])){
                $categories = implode(",",$data['categories']);
            }else{
                $categories ="";
            }

            if(isset($data['brands'])){
                $brands = implode(",",$data['brands']);
            }else{
                $brands ="";
            }

            if(isset($data['users'])){
                $users = implode(",",$data['users']);
            }else{
                $users ="";
            }

            if($data['coupon_option']=="Automatic"){
                $coupon_code = str_random(8);
            }else{
                $coupon_code = $data['coupon_code'];
            }

            $adminType = Auth::guard('admin')->user()->type;

            if($adminType=="vendor"){
                $coupon->vendor_id = Auth::guard('admin')->user()->vendor_id;
            }else{
                $coupon->vendor_id = 0;
            }

            $coupon->coupon_option = $data['coupon_option'];
            $coupon->coupon_code = $coupon_code;
            $coupon->categories =$categories;
            $coupon->brands =$brands;
            $coupon->users =$users;
            $coupon->coupon_type =$data['coupon_type'];
            $coupon->amount_type =$data['amount_type'];
            $coupon->amount =$data['amount'];
            $coupon->expiry_date =$data['expiry_date'];
            $coupon->status = 1;
            $coupon->save();

            return redirect('admin/coupons')->with('success_message',$message);
        }

        //set section
        $categories = Section::with('categories')->get()->toArray();
        //dd($categories);

        //get all brand
        $brands = Brand::where('status',1)->get()->toArray();
        //get all user
        $users = User::select('email')->where('status',1)->get();
        
        return view('admin.coupons.add_edit_coupon')->with(compact('title','coupon','categories','brands','users','selCats','selBrands','selUsers'));
    }
}
