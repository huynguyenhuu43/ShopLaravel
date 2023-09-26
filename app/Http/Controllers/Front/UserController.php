<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Session;
use Hash;

use function PHPSTORM_META\type;

class UserController extends Controller
{
    public function loginRegister(){
        return view('front.users.login_register');
    }
    public function userRegister(Request $request){
            if($request->ajax()){
                $data = $request->all();
                //echo "<pre>"; print_r($data); die;

                $validator = Validator::make($request->all(),[
                    'name'=>'required|string|max:100',
                    'mobile'=>'required|numeric|digits:10',
                    'email'=>'required|email|max:150|unique:users',
                    'password'=>'required|min:6',
                    'accept'=>'required'
                ],
                [
                    'accept.required'=>'Vui lòng chấp nhận điều khoản, điều kiện !'
                ]
            );
            if($validator->passes()){
                $user = new User;
                $user->name =$data['name'];
                $user->mobile =$data['mobile'];
                $user->email =$data['email'];
                $user->password =bcrypt($data['password']);
                $user->status =1;
                $user->save();

                //send

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    $redirectTo = url('cart');

                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }
                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                }
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

               
        }
    }

    public function userAccount(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $validator = Validator::make($request->all(),[
                'name'=>'required|string|max:100',
                'city'=>'required|string|max:100',
                'state'=>'required|string|max:100',
                'address'=>'required|string|max:100',
                'country'=>'required|string|max:100',
                'zipcode'=>'required|numeric|digits:6',
                'mobile'=>'required|numeric|digits:10'
                
            ]);
            if($validator->passes()){
               //update user
               User::where('id',Auth::user()->id)->update(['name'=>$data['name'],'mobile'=>$data['mobile'],'city'=>$data['city'],'state'=>$data['state'],'country'=>$data['country'],'zipcode'=>$data['zipcode'],'address'=>$data['address']]);

             
               return response()->json(['type'=>'success','message'=>'Cập nhật thông tin thành công !']);
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
        }else{
            return view('front.users.user_account');
        }
    }

    public function userUpdatePassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $validator = Validator::make($request->all(),[
                'current_password'=>'required',
                'new_password'=>'required|min:6',
                'confirm_password'=>'required|min:6|same:new_password',
                
                
            ]);
            if($validator->passes()){
               //update password
               $current_password = $data['current_password'];
               $checkPassword = User::where('id',Auth::user()->id)->first();
               if(Hash::check($current_password,$checkPassword->password)){
                $user = User::find(Auth::user()->id);
                $user->password = bcrypt($data['new_password']);
                $user->save();
                return response()->json(['type'=>'success','message'=>'Thay đổi mật khẩu thành công !']);
               }else{
                return response()->json(['type'=>'incorrect','message'=>'Mật khẩu cũ không chính xác !']);
               }
               return response()->json(['type'=>'success','message'=>'Cập nhật thông tin thành công !']);
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
        }else{
            return view('front.users.user_account');
        }
    }

    public function userLogin(Request $request){
        if($request->Ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $validator = Validator::make($request->all(),[
                'email'=>'required|email|max:150|exists:users',
                'password'=>'required|min:6'
                ]);
            if($validator->passes()){

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){

                    if(Auth::user()->status==0){
                        Auth::logout();
                        return response()->json(['type'=>'inactive','message'=>'Tài khoản của bạn bị vô hiệu hóa. Vui lòng liên hệ quản trị viên !']);
                    }

                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }
                    $redirectTo = url('cart');
                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                }else{
                    return response()->json(['type'=>'incorrect','message'=>'Tài khoản hoặc mật khẩu không đúng !']);
                }

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
        }
    }



    public function userLogout(){
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}
