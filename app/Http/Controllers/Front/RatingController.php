<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;
use Auth;

class RatingController extends Controller
{
    public function addRating(Request $request){
        if(!Auth::check()){
            $message = "Bạn phải đăng nhập để đánh giá sản phẩm !";
            return redirect()->back()->with('error_message',$message);
        }
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $user_id=Auth::user()->id;
            //check nếu user da danh gia sp nay r
            $ratingCount = Rating::where(['user_id'=>$user_id,'product_id'=>$data['product_id']])->count();
            if($ratingCount>0){
                $message = "Bạn đã đánh giá sản phẩm này rồi !";
                return redirect()->back()->with('error_message',$message);
            }else{
                if(empty($data['rating'])){
                    $message = "Hãy thêm xếp hạng cho sản phẩm này !";
                    return redirect()->back()->with('error_message',$message);
                }else{
                    // echo "Thêm đánh giá"; die;
                    $rating = new Rating;
                    $rating->user_id =$user_id;
                    $rating->product_id =$data['product_id'];
                    $rating->review =$data['review'];
                    $rating->rating =$data['rating'];
                    $rating->status =1;
                    $rating->save();
                    $message = "Cảm ơn bạn đã đánh giá cho sản phẩm này !";
                    return redirect()->back()->with('success_message',$message);
                }
                
            }
        }
    }
        

}
