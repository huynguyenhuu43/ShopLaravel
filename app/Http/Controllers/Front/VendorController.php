<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Validator;
use DB;

class VendorController extends Controller
{
    public function loginRegister(){
        return view('front.vendors.login_register');
    }

    public function vendorRegister(Request $request){
        if($request->isMethod('post')){
            $data =$request->all();
            //echo "<pre>"; print_r($data); die;

            $rules = [
                "name"=>"required",
                "email"=>"required|email|unique:admins|unique:vendors",
                "mobile"=>"required|min:10|numeric|unique:admins|unique:vendors",
                "accept"=>"required",
            ];
            $customMessages =[
                "name.required"=>"Tên là bắt buộc",
                "email.required"=>"Email là bắt buộc",
                "email.unique"=>"Email đã được sử dụng",
                "mobile.required"=>"SĐT là bắt buộc",
                "mobile.unique"=>"SĐT đã được sử dụng",
                "accept.required"=>"Vui lòng chấp nhận điều khoản",
            ];
            $validator = Validator::make($data,$rules,$customMessages);
            if($validator->fails()){
                return Redirect::back()->withErrors($validator);
            }

            DB::beginTransaction();

            //tạo tk nhà cung cấp
            $vendor = new Vendor;
            $vendor->name= $data['name'];
            $vendor->mobile= $data['mobile'];
            $vendor->email= $data['email'];
            $vendor->status= 1;

            //set time zone
            date_default_timezone_set("Asia/Ho_Chi_Minh"); // Đặt múi giờ mặc địn
            $vendor->created_at =date("Y-m-d H:i:s");
            $vendor->updated_at =date("Y-m-d H:i:s");
            $vendor->save();


           

            $vendor_id = DB::getPdo()->lastInsertId();

            //chèn vendor vào bảng admin
            $admin = new Admin;
            $admin->type= 'vendor';
            $admin->vendor_id= $vendor_id;
            $admin->name= $data['name'];
            $admin->mobile= $data['mobile'];
            $admin->email= $data['email'];
            $admin->password= bcrypt($data['password']);
            $admin->status= 1;//chỗ này nếu muốn tạo tk xong phải chờ admin click vào trangj thái thì mới login dược thì là 0

            //set time zone
            date_default_timezone_set("Asia/Ho_Chi_Minh"); // Đặt múi giờ mặc địn
            $admin->created_at =date("Y-m-d H:i:s");
            $admin->updated_at =date("Y-m-d H:i:s");
            $admin->save();

            

            DB::commit();

            
            //redirec back with success message
            $message = "Cảm ơn vì đã trở thành nhà cung cấp. Chúng tôi sẽ xác nhận bằng email khi tài khoản được phê duyệt.";
            return redirect()->back()->with('success_message',$message);
        }
    }
}
