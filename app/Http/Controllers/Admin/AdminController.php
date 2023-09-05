<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Image;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function updateAdminPassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            //check if mk cu nhap boi admin chinh xac
            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
                //check mk moi trung voi xac nhan mk moi
                if($data['confirm_password']==$data['new_password']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message','Đổi mật khẩu thành công !');
                }else{
                    return redirect()->back()->with('error_message','Mật khẩu mới và xác nhận mật khẩu mới không trùng khớp !');
                }
            }else{
                return redirect()->back()->with('error_message','Mật khẩu cũ của bạn không chính xác !');
            }
        }
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }

    public function checkAdminPassword(Request $request){
        $data =$request->all();
        //echo "<pre>"; print_r($data); die;
        if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }
    }

    public function updateAdminDetails(Request $request){
        if($request->isMethod('post')){
            $data = $request ->all();
            //echo "<pre>"; print_r($data); die;
            $rules = [
                'admin_name'=> 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
            ];
            $customMessages =[
                'admin_name.required'=> 'Bạn phải nhập tên !',
                'admin_name.regex'=> 'Định dạng tên không đúng !',
                'admin_mobile.required'=> 'Bạn phải nhập số điện thoại !',
                'admin_mobile.numeric'=> 'Định dạng số điện thoại không đúng !',
            ];

            $this->validate($request,$rules,$customMessages);
            //upload admin photo
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()){
                    //get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'admin/images/photos/'.$imageName;
                    Image::make($image_tmp)->save($imagePath);
                }
            }else if(!empty($data['current_admin_image'])){
                $imageName = $data['current_admin_image'];
            }else{
                $imageName = "";
            }

            //update admin details
            Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'],'image'=>$imageName]);
            return redirect()->back()->with('success_message','Cập nhật thông tin thành công !');
        }
        return view('admin.settings.update_admin_details');
    }

    public function updateVendorDetails($slug,Request $request){
        if($slug=="personal"){
            if($request->isMethod('post')){
                $data = $request ->all();
                //echo "<pre>"; print_r($data); die;

                $rules = [
                    'vendor_name'=> 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_city'=> 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_mobile' => 'required|numeric',
                ];
                $customMessages =[
                    'vendor_name.required'=> 'Bạn phải nhập tên !',
                    'vendor_city.required'=> 'Bạn phải nhập tên thành phố !',
                    'vendor_name.regex'=> 'Định dạng tên không đúng !',
                    'vendor_city.regex'=> 'Định dạng không đúng !',
                    'vendor_mobile.required'=> 'Bạn phải nhập số điện thoại !',
                    'vendor_mobile.numeric'=> 'Định dạng số điện thoại không đúng !',
                ];
    
                $this->validate($request,$rules,$customMessages);
                //upload admin photo
                if($request->hasFile('vendor_image')){
                    $image_tmp = $request->file('vendor_image');
                    if($image_tmp->isValid()){
                        //get image extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'admin/images/photos/'.$imageName;
                        Image::make($image_tmp)->save($imagePath);
                    }
                }else if(!empty($data['current_vendor_image'])){
                    $imageName = $data['current_vendor_image'];
                }else{
                    $imageName = "";
                }
    
                //update in admin table
                Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['vendor_name'],'mobile'=>$data['vendor_mobile'],'image'=>$imageName]);
                //update in vendor table
                Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->update(['name'=>$data['vendor_name'],'mobile'=>$data['vendor_mobile'],'address'=>$data['vendor_address'],'city'=>$data['vendor_city'],'state'=>$data['vendor_state'],'country'=>$data['vendor_country'],'zipcode'=>$data['vendor_zipcode']]);
                return redirect()->back()->with('success_message','Cập nhật thông tin thành công !');
            }
            $vendorDetails = Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        }else if($slug=="business"){

        }else if($slug=="bank"){

        }
        return view('admin.settings.update_vendor_details')->with(compact('slug','vendorDetails'));
    }

    public function login(Request $request){
        //echo $password = Hash::make('123456'); die;

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre"; print_r($data); die;
            //xac thuc phia may chu
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];
            $customMessages = [
                //tuy chinh thong bao loi
                'email.required' => 'Bạn chưa nhập Email !',
                'email.email' => 'Định dạng email không đúng !',
                'password.required' => 'Bạn chưa nhập mật khẩu !',
            ];
            $this->validate($request,$rules,$customMessages);

            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1])){
                return redirect('admin/dashboard');
            }else{
                return redirect()->back()->with('error_message','Invalid Email or Password');
            }
        }
        return view('admin.login');
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
