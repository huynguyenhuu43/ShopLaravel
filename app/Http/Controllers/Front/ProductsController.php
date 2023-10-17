<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\ProductsFilter;
use App\Models\Vendor;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrdersProduct;
use App\Models\Rating;
use App\Models\User;
use Session;
use DB;
use Auth;

class ProductsController extends Controller
{
    public function listing(Request $request){
        if($request->ajax()){
            $data =$request->all();
            //echo "<pre>"; print_r($data); die;

            $url = $data['url'];
            $_GET['sort']=$data['sort'];
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){
                $categoryDetails = Category::categoryDetails($url);
                //
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
                
                //check for Fabric
                $productFilters = ProductsFilter::productFilters();
                foreach ($productFilters as $key => $filter){
                    if(isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && !empty($filter['filter_column']) && !empty($data[$filter['filter_column']])){
                        $categoryProducts->whereIn($filter['filter_column'],$data[$filter['filter_column']]);
                    }
                }
                
                //check sort
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="product_latest"){
                        $categoryProducts->orderby('products.id','Desc');
                    }else if($_GET['sort']=="price_lowest"){
                        $categoryProducts->orderby('products.product_price','Asc');
                    }else if($_GET['sort']=="price_highest"){
                        $categoryProducts->orderby('products.product_price','Desc');
                    }else if($_GET['sort']=="name_a_z"){
                        $categoryProducts->orderby('products.product_name','Asc');
                    }else if($_GET['sort']=="name_z_a"){
                        $categoryProducts->orderby('products.product_name','Desc');
                    }
                }

                //check for size
                if(isset($data['size']) && !empty($data['size'])){
                    $productIds =ProductsAttribute::select('product_id')->whereIn('size',$data['size'])->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                //check for color
                if(isset($data['color']) && !empty($data['color'])){
                    $productIds = Product::select('id')->whereIn('product_color',$data['color'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                //check for price
               /* if(isset($data['price']) && !empty($data['price'])){
                    foreach ($data['price'] as $key =>$price){
                        $priceArr = explode("-",$price);
                        $productIds[]= Product::select('id')->whereBetween('product_price',[$priceArr[0],$priceArr[1]])->pluck('id')->toArray();
                    }
                    $productIds = call_user_func_array('array_merge',$productIds);
                    $categoryProducts->whereIn('products.id',$productIds);
                }*/
                //check for price
                $productIds = array();
                if(isset($data['price']) && !empty($data['price'])){
                    foreach ($data['price'] as $key =>$price){
                        $priceArr = explode("-",$price);
                        if(isset($priceArr[0]) && isset($priceArr[1])){
                            $productIds[]= Product::select('id')->whereBetween('product_price',[$priceArr[0],$priceArr[1]])->pluck('id')->toArray();
                        }
                    }
                    $productIds = array_unique(array_flatten($productIds));
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                //check for brand
                if(isset($data['brand']) && !empty($data['brand'])){
                    $productIds = Product::select('id')->whereIn('brand_id',$data['brand'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                $categoryProducts= $categoryProducts->paginate(15);
                //dd($categoryDetails);
                // echo "Category exists"; die;
                return view('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{
                abort(404);
            }
        }else{
            if(isset($_REQUEST['search']) && !empty($_REQUEST['search'])){
                $search_product =$_REQUEST['search'];
                $categoryDetails['breadcrumbs'] = $search_product;
                $categoryDetails['categoryDetails']['category_name'] =$search_product;
                $categoryDetails['categoryDetails']['description'] = "Search Product for ". $search_product;
                $categoryProducts = Product::select('products.id','products.section_id','products.category_id','products.brand_id','products.vendor_id','products.product_name','products.product_code','products.product_color','products.product_price','products.product_discount','products.product_image','products.description')->with('brand')->join('categories','categories.id','=','products.category_id')->where(function($query)use($search_product){
                    $query->where('products.product_name','like','%'.$search_product.'%')
                    ->orWhere('products.product_code','like','%'.$search_product.'%')
                    ->orWhere('products.product_color','like','%'.$search_product.'%')
                    ->orWhere('products.description','like','%'.$search_product.'%')
                    ->orWhere('categories.category_name','like','%'.$search_product.'%');
                })->where('products.status',1);
                if(isset($_REQUEST['section_id']) && !empty($_REQUEST['section_id'])){
                    $categoryProducts = $categoryProducts->where('products.section_id',$_REQUEST['section_id']);
                }
                $categoryProducts = $categoryProducts->get();
                // dd($categoryProducts);
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts'));
            }else{
                $url = Route::getFacadeRoot()->current()->uri();
                $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
                if($categoryCount>0){
                    $categoryDetails = Category::categoryDetails($url);
                    //
                    $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
                    
                    //check sort
                    if(isset($_GET['sort']) && !empty($_GET['sort'])){
                        if($_GET['sort']=="product_latest"){
                            $categoryProducts->orderby('products.id','Desc');
                        }else if($_GET['sort']=="price_lowest"){
                            $categoryProducts->orderby('products.product_price','Asc');
                        }else if($_GET['sort']=="price_highest"){
                            $categoryProducts->orderby('products.product_price','Desc');
                        }else if($_GET['sort']=="name_a_z"){
                            $categoryProducts->orderby('products.product_name','Asc');
                        }else if($_GET['sort']=="name_z_a"){
                            $categoryProducts->orderby('products.product_name','Desc');
                        }
                    }
                    $categoryProducts= $categoryProducts->paginate(15);
                    //dd($categoryDetails);
                    // echo "Category exists"; die;
                    return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url'));
                }else{
                    abort(404);
                }
            }
            
        }
       
    }

    public function vendorListing($vendorid){
        $getVendorShop = Vendor::getVendorShop($vendorid);
        $vendorProducts = Product::with('brand')->where('vendor_id',$vendorid)->where('status',1);
        $vendorProducts = $vendorProducts->paginate(30);
        return view('front.products.vendor_listing')->with(compact('getVendorShop','vendorProducts'));
    }

    public function detail($id){
        $productDetails = Product::with(['section','category','brand','attributes'=>function($query){
            $query->where('stock','>',0)->where('status',1);
        },'images','vendor'])->find($id)->toArray();
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
        //dd($productDetails);

        //getsimilar product
        $similarProducts = Product::with('brand')->where('category_id',$productDetails['category']['id'])->where('id','!=',$id)->limit(4)->inRandomOrder()->get()->toArray();
        
        //set session
        if(empty(Session::get('session_id'))){
            $session_id= md5(uniqid(rand(), true));
        }else{
            $session_id=Session::get('session_id');
        }

        Session::put('session_id',$session_id);

        //insert
        $countRecentlyViewedProducts = DB::table('recently_viewed_products')->where(['product_id'=>$id,'session_id'=>$session_id])->count();
        if($countRecentlyViewedProducts==0){
            DB::table('recently_viewed_products')->insert(['product_id'=>$id,'session_id'=>$session_id]);
        }
        //get recently
        $recentProductsIds =DB::table('recently_viewed_products')->select('product_id')->where('product_id','!=',$id)->where('session_id',$session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');

        //get rectly view
        $recentlyViewedProducts = Product::with('brand')->whereIn('id',$recentProductsIds)->get()->toArray();

        //get group product (color)
        $groupProducts = array();
        if(!empty($productDetails['group_code'])){
            $groupProducts = Product::select('id','product_image')->where('id','!=',$id)->where(['group_code'=>$productDetails['group_code'],'status'=>1])->get()->toArray();
            //dd($groupProducts);
        }
        //ratings
        $ratings = Rating::with('user')->where(['product_id'=>$id,'status'=>1])->get()->toArray();
        //average rating
        $ratingSum = Rating::where(['product_id'=>$id,'status'=>1])->sum('rating');
        $ratingCount=Rating::where(['product_id'=>$id,'status'=>1])->count();
        $avgRating=Rating::where(['product_id'=>$id,'status'=>1])->count();
        $avgStarRating=Rating::where(['product_id'=>$id,'status'=>1])->count();

        //getstar rating
        $ratingOneStarCount=Rating::where(['product_id'=>$id,'status'=>1,'rating'=>1])->count();
        $ratingTwoStarCount=Rating::where(['product_id'=>$id,'status'=>1,'rating'=>2])->count();
        $ratingThreeStarCount=Rating::where(['product_id'=>$id,'status'=>1,'rating'=>3])->count();
        $ratingFourStarCount=Rating::where(['product_id'=>$id,'status'=>1,'rating'=>4])->count();
        $ratingFiveStarCount=Rating::where(['product_id'=>$id,'status'=>1,'rating'=>5])->count();

        if($ratingCount>0){
            $avgRating = round($ratingSum/$ratingCount,2);
            $avgStarRating =round($ratingSum/$ratingCount);
        }


       $totalStock =  ProductsAttribute::where('product_id',$id)->sum('stock'); 
       //dd($similarProducts);
       return view('front.products.detail')->with(compact('productDetails','categoryDetails','totalStock','similarProducts','recentlyViewedProducts','groupProducts','ratings','avgRating','avgStarRating','ratingOneStarCount','ratingTwoStarCount','ratingThreeStarCount','ratingFourStarCount','ratingFiveStarCount'));
    }

    public function getProductPrice(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'],$data['size']);
            return $getDiscountAttributePrice;
        }
    }

    public function cartAdd(Request $request){
        if($request->isMethod('post')){
            $data =$request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['quantity']<=0){
                $data['quantity']=1;
            }
            $getProductStock = ProductsAttribute::getProductStock($data['product_id'],$data['size']);
            if($getProductStock<$data['quantity']){
                return redirect()->back()->with('error_message','Số lượng sản phẩm không đủ !');
            }

            //generate session
            $session_id=Session::get('session_id');
            if(empty($session_id)){
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
            }

            //check sp co trong gio hang chua?
            if(Auth::check()){
                $user_id = Auth::user()->id;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>$user_id])->count();
            }else{
                $user_id=0;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>$session_id])->count();
            }

            if($countProducts>0){
                return redirect()->back()->with('error_message','Sản phẩm đã có trong giỏ hàng !');
            }
            //save product
            $item = new Cart;
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = $data['quantity'];
            $item->save();
            return redirect()->back()->with('success_message','Đã thêm sản phẩm vào giỏ hàng ! <a style="text-decoration:underline !important" href="/cart">Xem giỏ hàng</a>');
        }
    }

    public function cart(){
        $getCartItems = Cart::getCartItems();
        //dd($getCartItems);
        return view('front.products.cart')->with(compact('getCartItems'));
    }
    public function cartUpdate(Request $request){
        if($request->ajax()){
            $data = $request->all();

            //get cart details
            $cartDetails = Cart::find($data['cartid']);
            //lay sp ton
            $availableStock = ProductsAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size']])->first()->toArray();
            //
            // echo "<pre>"; print_r($availableStock); die;
            if($data['qty']>$availableStock['stock']){
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'Số lượng sản phẩm không đủ !',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
            }

            //check neu con size san pham
            $availableSize = ProductsAttribute::where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size'],'status'=>1])->count();
            if($availableSize==0){
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'Số lượng size không đủ !',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
            }

            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);
            $getCartItems = Cart::getCartItems();
            $totalCartItems =totalCartItems();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            return response()->json([
                'status'=>true,
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
            ]);
        }
    }
    public function cartDelete(Request $request){
            if($request->ajax()){
                Session::forget('couponAmount');
                Session::forget('couponCode');
                $data = $request->all();
                Cart::where('id',$data['cartid'])->delete();
                $getCartItems = Cart::getCartItems();
                $totalCartItems =totalCartItems();
                return response()->json([
                    'totalCartItems'=>$totalCartItems,
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
        }
    }

    public function applyCoupon(Request $request){
        if($request->ajax()){
            $data = $request->all();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            // echo "<pre>"; print_r($data); die;
            $getCartItems = Cart::getCartItems();
            $totalCartItems =totalCartItems();
            $couponCount = Coupon::where('coupon_code',$data['code'])->count();
            if($couponCount==0){
                return response()->json([
                    'status'=>false,
                    'totalCartItems'=>$totalCartItems,
                    'message'=>'Mã giảm giá không tồn tại !',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
            }else{
                //get coupon
                $couponDetails = Coupon::where('coupon_code',$data['code'])->first();

                //check coupon hd
                if($couponDetails->status==0){
                    $message ="Mã giảm giá không hoạt động ";
                }
                //check coupon hết hạn
                $expiry_date =$couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if($expiry_date < $current_date){
                    $message = "Mã giảm giá đã hết hạn!";
                }
                //check neu coupon duoc dung r
                if($couponDetails->coupon_type=="Single Time"){
                    //check dung r
                    $couponCount = Order::where(['coupon_code'=>$data['code'],'user_id'=>Auth::user()->id])->count();
                    if($couponCount>=1){
                        $message ="Mã giảm giá đã được sử dụng !";
                    }
                }
                //check sp nao dc ap dung coupon
                $carArr = explode(",",$couponDetails->categories);
                $total_amount =0;
                foreach($getCartItems as $key => $item){
                    if(!in_array($item['product']['category_id'],$carArr)){
                        $message ="Mã giảm giá không áp dụng cho sản phẩm này !";
                    }
                    $attrPrice =Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                    //echo "<pre>"; print_r($attrPrice); die;
                    $total_amount = $total_amount +($attrPrice['final_price']*$item['quantity']);
                }
                //check uuser nao dc dung coupon
                if(isset($couponDetails->users)&&!empty($couponDetails->users)){
                    $usersArr = explode(",",$couponDetails->users);

                    if(count($usersArr)){
                        foreach($usersArr as $key => $user){
                            $getUserId = User::select('id')->where('email',$user)->first()->toArray();
                            $userId[]=$getUserId['id'];
                        }

                        foreach($getCartItems as  $item){
                            if(!in_array($item['user_id'],$userId)){
                                $message ="Mã giảm giá này không dành cho bạn. Hãy thử mã giảm giá khác !";
                            }
                        }
                    }
                }
                
                //check if cp belong to vendor product
                if($couponDetails->vendor_id>0){
                    $productIds = Product::select('id')->where('vendor_id',$couponDetails->vendor_id)->pluck('id')->toArray();
                    //echo "<pre>"; print_r($productIds); die;
                    foreach($getCartItems as $item){
                        if(!in_array($item['product']['id'],$productIds)){
                            $message ="Mã giảm giá này không dành cho bạn. Vì đây là dành riêng cho sản phẩm của nhà cung cấp !";
                        }
                    }
                }
                


                //if tin nhan loi
                if(isset($message)){
                    return response()->json([
                        'status'=>false,
                        'totalCartItems'=>$totalCartItems,
                        'message'=>$message,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                        'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                    ]);
                }else{
                    //copon k dung

                    //check type coupon fixe or precent
                    if($couponDetails->amount_type=="Fixed"){
                        $couponAmount = $couponDetails->amount;
                    }else{
                        $couponAmount = $total_amount * ($couponDetails->amount/100);
                    }
                    $grand_total = $total_amount - $couponAmount;

                    //add coupon code availa ble
                    Session::put('couponAmount',$couponAmount);
                    Session::put('couponCode',$data['code']);

                    $message ="Áp dụng mã giảm giá thành công !";

                    return response()->json([
                        'status'=>true,
                        'totalCartItems'=>$totalCartItems,
                        'couponAmount'=>$couponAmount,
                        'grand_total'=>$grand_total,
                        'message'=>$message,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                        'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                    ]);
                }
            }
        }
    }

    public function checkout(Request $request){

        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        $getCartItems = Cart::getCartItems();
        //dd($deliveryAddresses);
        if(count($getCartItems)==0){
            $message ="Giỏ hàng của bạn đang trống! Vui lòng mua ít nhất 1 sản phẩm";
            return redirect('cart')->with('error_message',$message);
        }
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            //web secure
            foreach ($getCartItems as $item){
                $product_status = Product::getProductStatus($item['product_id']);
                if($product_status==0){
                    // Product::deleteCartProduct($item['product_id']);
                    // $message = "Một trong các sản phẩm đang tạm ngưng bán! Vui lòng thử lại.";
                    $message = $item['product']['product_name']." - ".$item['size']." Phân loại này tạm ngưng bán. Vui lòng chọn sản phẩm khác.";
                    return redirect('/cart')->with('error_message',$message);
                }

                //check sp nao bán hết
                $getProductStock = ProductsAttribute::getProductStock($item['product_id'],$item['size']);
                if($getProductStock==0){
                    // Product::deleteCartProduct($item['product_id']);
                    // $message = "Sản phẩm đã hết hàng! Vui lòng thử lại.";
                    $message = $item['product']['product_name']." - ".$item['size']." Sản phẩm tạm ngưng bán. Vui lòng chọn sản phẩm khác.";
                    return redirect('/cart')->with('error_message',$message);
                }

                //check thuoc tinh nao k hd
                $getAttributeStatus = ProductsAttribute::getAttributeStatus($item['product_id'],$item['size']);
                if($getAttributeStatus==0){
                    // Product::deleteCartProduct($item['product_id']);
                    // $message = "Phân loại này đã hết hàng! Vui lòng thử lại.";
                    $message = $item['product']['product_name']." - ".$item['size']." Phân loại này tạm ngưng bán. Vui lòng chọn sản phẩm khác.";
                    return redirect('/cart')->with('error_message',$message);
                }
                //check phan loai nao k haot dong
                $getCategoryStatus = Category::getCategoryStatus($item['product']['category_id']);
                if($getCategoryStatus==0){
                    //Product::deleteCartProduct($item['product_id']);
                    //$message = "Phân loại này đã hết hàng! Vui lòng thử lại.";
                    $message = $item['product']['product_name']." - ".$item['size']." Phân loại này tạm ngưng bán. Vui lòng chọn sản phẩm khác.";
                    return redirect('/cart')->with('error_message',$message);
                }
            }

            if(empty($data['address_id'])){
                $message = "Vui lòng chọn 1 địa chỉ nhận hàng !";
                return redirect()->back()->with('error_message',$message);
            };

            if(empty($data['payment_gateway'])){
                $message = "Vui lòng chọn 1 phương thức thanh toán !";
                return redirect()->back()->with('error_message',$message);
            };

            if(empty($data['accept'])){
                $message = "Vui lòng chấp nhận các điều khoản !";
                return redirect()->back()->with('error_message',$message);
            };
            //get address
            $deliveryAddress = DeliveryAddress::where('id',$data['address_id'])->first()->toArray();
            //dd($deliveryAddress);
            //set COD neu COD dược chọn
            if($data['payment_gateway']=="COD"){
                $payment_method = "COD";
                $order_status ="New";
            }else{
                $payment_method = "Prepaid";
                $order_status ="Pending";
            }
            DB::beginTransaction();
            //lay tong so tien
            $total_price =0;
            foreach($getCartItems as $item){
                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']);
            }
            //tinh tien ship
            $shipping_charges =0;
            //tính tổng tiền
            $grand_total = $total_price + $shipping_charges - Session::get('couponAmount') ;
            //insert grand total
            Session::put('grand_total',$grand_total);
            //insert vào bảng order
            $order = new Order;
            $order->user_id=Auth::user()->id;
            $order->name=$deliveryAddress['name'];
            $order->address=$deliveryAddress['address'];
            $order->state=$deliveryAddress['state'];
            $order->city=$deliveryAddress['city'];
            $order->country=$deliveryAddress['country'];
            $order->zipcode=$deliveryAddress['zipcode'];
            $order->mobile=$deliveryAddress['mobile'];
            $order->email=Auth::user()->email;
            $order->shipping_charges =$shipping_charges;
            $order->coupon_code =Session::get('couponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status =$order_status;
            $order->payment_method =$payment_method;
            $order->payment_gateway =$data['payment_gateway'];
            $order->grand_total =$grand_total;
            $order->save();
            $order_id = DB::getPdo()->lastInsertId();

            foreach($getCartItems as $item){
               $cartItem = new OrdersProduct;
               $cartItem->order_id = $order_id;
               $cartItem->user_id = Auth::user()->id;
               $getProductDetails = Product::select('product_code','product_name','product_color','admin_id','vendor_id')->where('id',$item['product_id'])->first()->toArray();
            //    dd($getProductDetails);
            $cartItem->admin_id = $getProductDetails['admin_id'];
            $cartItem->vendor_id = $getProductDetails['vendor_id'];
            $cartItem->product_id = $item['product_id'];
            $cartItem->product_code = $getProductDetails['product_code'];
            $cartItem->product_name = $getProductDetails['product_name'];
            $cartItem->product_color = $getProductDetails['product_color'];
            $cartItem->product_size = $item['size'];
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
            $cartItem->product_price = $getDiscountAttributePrice['final_price'];
            $cartItem->product_qty = $item['quantity'];
            $cartItem->save();

            //reduce stock scrpt
            $getProductStock = ProductsAttribute::getProductStock($item['product_id'],$item['size']);
            $newStock = $getProductStock - $item['quantity'];
            ProductsAttribute::where(['product_id'=>$item['product_id'],'size'=>$item['size']])->update(['stock'=>$newStock]);
            //reduce stock

            }
            //inser oder id
            Session::put('order_id',$order_id);

            DB::commit();
            

            if($data['payment_gateway']=="Paypal"){
                return redirect('/paypal');
            }else{
                echo "Phương thức thanh toán này sắp ra mắt";
            }
            return redirect('thanks');

        }
       
        return view('front.products.checkout')->with(compact('deliveryAddresses','getCartItems'));
    }
    public function thanks(){
        if(Session::has('order_id')){
            Cart::where('user_id',Auth::user()->id)->delete();
            return view('front.products.thanks');
        }else{
            return redirect('cart');
        }
        
    }
}
