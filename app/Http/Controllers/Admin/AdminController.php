<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash as FacadesHash;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function updateAdminPassword(Request $request){
        if($request->isMethod('post')){
            $data =$request->all();
            //echo "<pre>"; print_r($data); die;
            //check if mk cu nhap boi admin chinh xac
            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){

            }else{
                return redirect()->back()->with('error_message'.'Mật khẩu cũ của bạn không chính xác !');
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
