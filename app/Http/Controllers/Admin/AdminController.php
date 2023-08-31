<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
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
