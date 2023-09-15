<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Session;
use Image;

class BannersController extends Controller
{
    public function banners(){
        Session::put('page','banners');
        $banners = Banner::get()->toArray();
        return view('admin.banners.banners')->with(compact('banners'));
    }

    public function updateBannerStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);
        }
    }

    public function deleteBanner($id){
        //get banner
        $bannerImage =Banner::where('id',$id)->first();
        $banner_image_path = 'front/images/banner_images/';
        if(file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }
        //delete
        Banner::where('id',$id)->delete();

        return redirect('admin/banners')->with('success_message','Xóa banner thành công !');
    }

    public function addEditBanner(Request $request,$id=null){
        Session::put('page','banners');
        if($id==""){
            //add banner
            $banner = new Banner;
            $title = "Thêm Banner";
            $message ="Thêm banner thành công";
        }else{
            $banner = Banner::find($id);
            $title = "Sửa Banner";
            $message ="Sửa banner thành công";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $banner->type =$data['type'];
            $banner->link =$data['link'];
            $banner->title =$data['title'];
            $banner->alt =$data['alt'];
            $banner->status =1;

            if($data['type']=="Slider"){
                $width ="1920";
                $height ="720";
            }else if($data['type']=="Fix"){
                $width ="1920";
                $height ="450";
            }

            //upload banner photo
            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    //get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'front/images/banner_images/'.$imageName;
                    Image::make($image_tmp)->resize($width,$height)->save($imagePath);
                    $banner->image = $imageName;
                }
            }

            $banner->save();
            return redirect('admin/banners')->with('success_message',$message);
        }

        return view('admin.banners.add_edit_banner')->with(compact('title','banner'));
    }
}
