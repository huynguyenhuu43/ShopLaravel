<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Country;
use App\Models\Section;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Brand;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorsBusinessDetail;
use App\Models\VendorsBankDetail;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Image;
use Session;

class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page','dashboard');
        $sectionsCount = Section::count();
        $categoriesCount = Category::count();
        $productsCount = Product::count();
        $ordersCount = Order::count();
        $couponsCount = Coupon::count();
        $brandsCount = Brand::count();
        $usersCount = User::count();
        $vendorsCount = Vendor::count();
        return view('admin.dashboard')->with(compact('sectionsCount','categoriesCount','productsCount','ordersCount','couponsCount','brandsCount','usersCount','vendorsCount'));
    }

    public function updateAdminPassword(Request $request){
        Session::put('page','update_admin_password');
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
        Session::put('page','update_admin_details');
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
            Session::put('page','update_personal_details');
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
            Session::put('page','update_business_details');
             if($request->isMethod('post')){
                $data = $request ->all();
                //echo "<pre>"; print_r($data); die;

                $rules = [
                    'shop_name'=> 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_city'=> 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_mobile' => 'required|numeric',
                    'address_proof' => 'required',
                ];
                $customMessages =[
                    'shop_name.required'=> 'Bạn phải nhập tên !',
                    'shop_city.required'=> 'Bạn phải nhập tên thành phố !',
                    'shop_name.regex'=> 'Định dạng tên không đúng !',
                    'shop_city.regex'=> 'Định dạng không đúng !',
                    'shop_mobile.required'=> 'Bạn phải nhập số điện thoại !',
                    'shop_mobile.numeric'=> 'Định dạng số điện thoại không đúng !',
                ];
    
                $this->validate($request,$rules,$customMessages);
                //upload admin photo
                if($request->hasFile('address_proof_image')){
                    $image_tmp = $request->file('address_proof_image');
                    if($image_tmp->isValid()){
                        //get image extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'admin/images/proofs/'.$imageName;
                        Image::make($image_tmp)->save($imagePath);
                    }
                }else if(!empty($data['current_address_proof'])){
                    $imageName = $data['current_address_proof'];
                }else{
                    $imageName = "";
                }

                $vendorCount =VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                if($vendorCount>0){
                    VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['shop_name'=>$data['shop_name'],'shop_mobile'=>$data['shop_mobile'],'shop_address'=>$data['shop_address'],'shop_city'=>$data['shop_city'],'shop_state'=>$data['shop_state'],'shop_country'=>$data['shop_country'],'shop_zipcode'=>$data['shop_zipcode'],'business_license_number'=>$data['business_license_number'],'gst_number'=>$data['gst_number'],'pan-number'=>$data['pan-number'],'address_proof'=>$data['address_proof'],'address_proof_image'=>$imageName]);

                }else{
                    VendorsBusinessDetail::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,'shop_name'=>$data['shop_name'],'shop_mobile'=>$data['shop_mobile'],'shop_address'=>$data['shop_address'],'shop_city'=>$data['shop_city'],'shop_state'=>$data['shop_state'],'shop_country'=>$data['shop_country'],'shop_zipcode'=>$data['shop_zipcode'],'business_license_number'=>$data['business_license_number'],'gst_number'=>$data['gst_number'],'pan-number'=>$data['pan-number'],'address_proof'=>$data['address_proof'],'address_proof_image'=>$imageName]);

                }
                    //update in vendor table
                return redirect()->back()->with('success_message','Cập nhật thông tin thành công !');
            }
            $vendorCount = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
            if($vendorCount>0){
                $vendorDetails = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            }else{
                $vendorDetails =array();
            }
           
            //dd($vendorDetails);
        }else if($slug=="bank"){
            Session::put('page','update_bank_details');
            if($request->isMethod('post')){
                $data = $request ->all();
                //echo "<pre>"; print_r($data); die;

                $rules = [
                    'bank_name'=> 'required|regex:/^[\pL\s\-]+$/u',
                    'account_holder_name'=> 'required|regex:/^[\pL\s\-]+$/u',
                    'account_number' => 'required|numeric',
                    //'bank_ifcs_code'=>'required|numeric',
                ];
                $customMessages =[
                    'bank_name.required'=> 'Bạn phải nhập tên ngân hàng !',
                    'account_holder_name.required'=> 'Bạn phải nhập tên tài khoản !',
                    'bank_name.regex'=> 'Định dạng không đúng !',
                    'account_holder_name.regex'=> 'Định dạng không đúng !',
                    'account_number.required'=> 'Bạn phải nhập số tài khoản !',
                    'account_number.numeric'=> 'Định dạng số tài khoản không đúng !',
                    //'bank_ifcs_code.required'=> 'Bạn phải nhập mã code !',
                ];
    
                $this->validate($request,$rules,$customMessages);
                $vendorCount =VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                if($vendorCount>0){
                    VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['account_holder_name'=>$data['account_holder_name'],'bank_name'=>$data['bank_name'],'account_number'=>$data['account_number'],'bank_ifsc_code'=>$data['bank_ifsc_code']]);

                }else{
                    VendorsBankDetail::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,'account_holder_name'=>$data['account_holder_name'],'bank_name'=>$data['bank_name'],'account_number'=>$data['account_number'],'bank_ifsc_code'=>$data['bank_ifsc_code']]);

                }
                    //update in vendor table
                return redirect()->back()->with('success_message','Cập nhật thông tin thành công !');
            }
            

            $vendorCount = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
            if($vendorCount>0){
                $vendorDetails = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            }else{
                $vendorDetails =array();
            }
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
    public function admins($type=null){
        $admins = Admin::query();
        if(!empty($type)){
            $admins = $admins->where('type',$type);
            $title = ucfirst($type)."s";
            Session::put('page','view_'.strtolower($title));
        }else{
            $title = "All Admins/Subadmins/Vendors";
            Session::put('page','view_all');
        }
        $admins = $admins->get()->toArray();
        //dd($admins);
        return view('admin.admins.admins')->with(compact('admins','title'));
    }

    public function viewVendorDetails($id){
        $vendorDetails = Admin::with('vendorPersonal','vendorBusiness','vendorBank')->where('id',$id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails),true);
        //dd($vendorDetails);
        return view('admin.admins.view_vendor_details')->with(compact('vendorDetails'));
    }

    public function updateAdminStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Admin::where('id',$data['admin_id'])->update(['status'=>$status]);
            //moi them 2 dong tu code (bật/tắt trạng thái của bảng vendors)
            $adminDetails = Admin::where('id',$data['admin_id'])->first()->toArray();
            Vendor::where('id',$adminDetails['vendor_id'])->update(['status'=>$status]);

            return response()->json(['status'=>$status,'admin_id'=>$data['admin_id']]);
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
