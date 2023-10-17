<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
        <div class="container">
        
            <div class="page-intro">
                <h2>Checkout</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{url('/')}}">Trang chủ</a>
                    </li>
                    <li class="is-marked">
                        <a href="{{url('/checkout')}}">Thanh toán</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Checkout-Page -->
    <div class="page-checkout u-s-p-t-80">
        <div class="container">
        @if(Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Lỗi: </strong> <?php echo Session::get('error_message'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        @endif
            
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        
                       
                
                            <div class="row" >
                                <!-- Billing-&-Shipping-Details -->
                                <div class="col-lg-6" id="deliveryAddresses">
                                    @include('front.products.delivery_addresses')
                                </div>

                                <!-- Billing-&-Shipping-Details /- -->
                                <!-- Checkout -->
                                <div class="col-lg-6">
                                <form name="checkoutForm" id="checkoutForm" action="{{ url('/checkout') }}" method="post">@csrf
                                @if(count($deliveryAddresses)>0)
                                <h4 class="section-h4">Địa chỉ giao hàng</h4>
                                @foreach($deliveryAddresses as $address)
                                <div class="control-group"><input type="radio" id="address{{$address['id']}}" name="address_id" value="{{$address['id']}}"></div>
                                <div><label class="control-group"  >{{$address['name']}}, {{$address['address']}}, {{$address['state']}}, {{$address['city']}}, {{$address['country']}}, ({{$address['mobile']}})</label>
                                <a style="float: right; margin-left:8px; " href="javascript:;" data-addressid="{{ $address['id'] }}" class="removeAddress">Xóa</a>&nbsp;&nbsp;
                                <a style="float: right;" href="javascript:;" data-addressid="{{ $address['id'] }}" class="editAddress">Sửa</a>
                            
                            </div>
                                @endforeach<br>
                             @endif
                                    <h4 class="section-h4">Đơn hàng của bạn</h4>
                                    <div class="order-table">
                                        <table class="u-s-m-b-13">
                                            <thead>
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th>Tổng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $total_price =0 @endphp
                                            @foreach($getCartItems as $item)
                                            <?php $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                                            //echo "<pre>"; print_r($getDiscountAttributePrice); die;
                                            ?>

                                                <tr>
                                                    <td>
                                                    <a href="{{url('product/'.$item['product_id'])}}">
                                                        <img style="max-width: 50px; max-height:50px;" src="{{ asset('front/images/product_images/small/'.$item['product']['product_image']) }}" alt="Product">
                                                        <h6 class="order-h6">{{$item['product']['product_name']}}<br> {{$item['size']}}/{{$item['product']['product_color']}}</h6>
                                                        <span class="order-span-quantity">x {{$item['quantity']}}</span>
                                                    </td>
                                                    <td>
                                                        <h6 class="order-h6">{{ number_format($getDiscountAttributePrice['final_price'] * $item['quantity'], 0, ',', '.') }} ₫</h6>
                                                    </td>
                                                </tr>
                                            @php $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']) @endphp
                                            @endforeach
                                                <tr>
                                                    <td>
                                                        <h3 class="order-h3">Tổng đơn hàng</h3>
                                                    </td>
                                                    <td>
                                                        <h3 class="order-h3">{{ number_format($total_price, 0, ',', '.') }} ₫</h3>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="order-h6">Phí vận chuyển</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="order-h6"> 0 ₫
                                                        </h6>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="order-h6">Mã giảm giá</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="order-h6">@if(Session::has('couponAmount'))
                                                                            {{ number_format(Session::get('couponAmount'), 0, ',', '.') }} ₫
                                                                            @else
                                                                            0 ₫
                                                                            @endif</h6>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h3 class="order-h3">Tổng</h3>
                                                    </td>
                                                    <td>
                                                        <h3 class="order-h3">{{ number_format($total_price - Session::get('couponAmount'), 0, ',', '.') }} ₫</h3>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="u-s-m-b-13">
                                            <input type="radio" class="radio-box" name="payment_gateway"  id="cash-on-delivery" value="COD">
                                            <label class="label-text" for="cash-on-delivery">Thanh toán khi nhận hàng</label>
                                        </div>
                                       
                                        <div class="u-s-m-b-13">
                                            <input type="radio" class="radio-box" name="payment_gateway" id="paypal" value="Paypal">
                                            <label class="label-text" for="paypal">Paypal</label>
                                        </div>
                                        <div class="u-s-m-b-13">
                                            <input type="checkbox" class="check-box" id="accept" name="accept" value="Yes" title="Vui lòng chấp nhận các điều khoản">
                                            <label class="label-text no-color" for="accept">Tôi đã đọc
                                                <a href="terms-and-conditions.html" class="u-c-brand">điều khoản và điều kiện</a>
                                            </label>
                                        </div>
                                        <button type="submit" class="button button-outline-secondary">Đặt hàng</button>
                                    </div>
                                </form>
                                </div>
                                <!-- Checkout /- -->
                            </div>
                
                    </div>
                </div>
           
        </div>
    </div>
    <!-- Checkout-Page /- -->
@endsection