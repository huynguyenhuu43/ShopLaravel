<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\DeliveryAddress;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Auth;

class AddressController extends Controller
{
    public function getDeliveryAddress(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $deliveryAddresses = DeliveryAddress::where('id',$data['addressid'])->first()->toArray();
            return response()->json(['address'=>$deliveryAddresses]);
            // echo "<pre>"; print_r($data); die;
        }
    }

    public function saveDeliveryAddress(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $address = array();
            $address['user_id']=Auth::user()->id;
            $address['name']=$data['delivery_name'];
            $address['address']=$data['delivery_address'];
            $address['state']=$data['delivery_state'];
            $address['city']=$data['delivery_city'];
            $address['country']=$data['delivery_country'];
            $address['zipcode']=$data['delivery_zipcode'];
            $address['mobile']=$data['delivery_mobile'];
            if(!empty($data['delivery_id'])){
                
                DeliveryAddress::where('id',$data['delivery_id'])->update($address);
            }else{
                // $address['status']=1;
                DeliveryAddress::create($address);
            }
            $deliveryAddresses = DeliveryAddress::deliveryAddresses();
            return response()->json(['view'=>(String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddresses'))]);
            
        }
    }

    public function removeDeliveryAddress(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            DeliveryAddress::where('id',$data['addressid'])->delete();
            $deliveryAddresses = DeliveryAddress::deliveryAddresses();
            return response()->json(['view'=>(String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddresses'))]);
        }
    }
}
