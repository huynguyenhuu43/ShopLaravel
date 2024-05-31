<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    
    public function section(){
        return $this->belongsTo('App\Models\Section','section_id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }

    public function brand(){
        return $this->belongsTo('App\Models\Brand','brand_id');
    }

    public function attributes(){
        return $this->hasMany('App\Models\ProductsAttribute');
    }

    public function images(){
        return $this->hasMany('App\Models\ProductsImage');
    }

    public function vendor(){
        return $this->belongsTo('App\Models\Vendor','vendor_id')->with('vendorbusinessdetails');
    }

    public static function getDiscountPrice($product_id){
        $proDetails = Product::select('product_price','product_discount','category_id')->where('id',$product_id)->first();
        $proDetails = json_decode(json_encode($proDetails),true);
        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first();
        $catDetails = json_decode(json_encode($catDetails),true);
        if($proDetails['product_discount']>0){
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price'] *$proDetails['product_discount']/100);
        }else if($catDetails['category_discount']>0){
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price'] *$catDetails['category_discount']/100);
        }else{
            $discounted_price =0;
        }
        return $discounted_price;
    }

    public static function getDiscountAttributePrice($product_id,$size){
        $proAttrPrice = ProductsAttribute::where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
        $proDetails = Product::select('product_discount','category_id')->where('id',$product_id)->first();
        $proDetails = json_decode(json_encode($proDetails),true);
        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first();
        $catDetails = json_decode(json_encode($catDetails),true);
        if($proDetails['product_discount']>0){
            $final_price = $proAttrPrice['price'] - ($proAttrPrice['price']*$proDetails['product_discount']/100);
            $discount = $proAttrPrice['price'] - $final_price;
        }else if($catDetails['category_discount']>0){
            $final_price = $proAttrPrice['price'] - ($proAttrPrice['price'] *$catDetails['category_discount']/100);
            $discount = $proAttrPrice['price'] - $final_price;
        }else{
            $final_price =$proAttrPrice['price'];
            $discount =0;
        }
        return array('product_price'=>$proAttrPrice['price'],'final_price'=>$final_price,'discount'=>$discount);
    }

    public static function isProductNew($product_id){
        $productIds = Product::select('id')->where('status',1)->orderby('id','Desc')->limit(3)->pluck('id');
        $productIds =json_decode(json_encode($productIds),true);
        //dd($productIds);
        if(in_array($product_id,$productIds)){
            $isProductNew ="Yes";
        }else{
            $isProductNew ="No";
        }
        return $isProductNew;
    }

    public static function getProductImage($product_id){
        $getProductImage = Product::select('product_image')->where('id',$product_id)->first()->toArray();
        return $getProductImage['product_image'];
    }
    public static function getProductStatus($product_id){
        $getProductStatus = Product::select('status')->where('id',$product_id)->first();
        return $getProductStatus->status;
    }
    public static function deleteCartProduct($product_id){
        Cart::where('product_id',$product_id)->delete();
    }
    
    
}


// Đại diện cho bảng trong cơ sở dữ liệu:

// Model Product đại diện cho bảng products trong cơ sở dữ liệu của bạn. Mỗi đối tượng của lớp Product tương ứng với một bản ghi trong bảng products.
// Định nghĩa mối quan hệ giữa các bảng:

// Các phương thức như section(), category(), brand(), attributes(), images(), vendor() định nghĩa các mối quan hệ giữa bảng products và các bảng khác như sections, categories, brands, products_attributes, products_images, và vendors.
// Những mối quan hệ này giúp bạn dễ dàng truy vấn dữ liệu liên quan một cách thuận tiện và hiệu quả.
// Thực hiện các logic nghiệp vụ:

// Các phương thức như getDiscountPrice(), getDiscountAttributePrice(), isProductNew(), getProductImage(), getProductStatus(), deleteCartProduct() chứa logic nghiệp vụ cụ thể liên quan đến sản phẩm.
// Ví dụ, getDiscountPrice() tính toán giá sản phẩm sau khi áp dụng các mức giảm giá, isProductNew() kiểm tra xem sản phẩm có phải là sản phẩm mới hay không.
// Tương tác với cơ sở dữ liệu:

// Model Product sử dụng Eloquent ORM của Laravel để tương tác với cơ sở dữ liệu. Eloquent cung cấp các phương thức như select(), where(), first(), pluck(), delete() để truy vấn và thao tác dữ liệu một cách dễ dàng và trực quan.
// Sử dụng Eloquent, bạn có thể thực hiện các truy vấn phức tạp một cách đơn giản mà không cần viết các câu lệnh SQL dài dòng.
// Sử dụng các tiện ích của Laravel:

// Model Product sử dụng trait HasFactory để hỗ trợ tạo dữ liệu giả lập trong quá trình phát triển và kiểm thử.
// Trait HasFactory giúp tạo ra các bản ghi mẫu trong cơ sở dữ liệu một cách nhanh chóng.
// Định nghĩa các phương thức tùy chỉnh:

// Model Product có thể chứa các phương thức tùy chỉnh như getDiscountPrice(), getProductImage(), deleteCartProduct(), giúp tổ chức và tái sử dụng logic nghiệp vụ một cách hiệu quả.
// Tóm lại, file model trong Laravel có vai trò trung gian giữa cơ sở dữ liệu và ứng dụng, giúp quản lý và thao tác dữ liệu một cách hiệu quả, đồng thời cung cấp các tiện ích mạnh mẽ của Eloquent ORM để xây dựng các ứng dụng web phức tạp.
