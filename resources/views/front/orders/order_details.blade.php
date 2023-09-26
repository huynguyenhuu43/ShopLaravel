<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>ID: #{{ $orderDetails['id']}}</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{url('/')}}">Trang chủ</a>
                </li>
                <li class="is-marked">
                    <a href="{{url('user/orders')}}">Đơn hàng của bạn</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Cart-Page -->
<div class="page-cart u-s-p-t-80">
    <div class="container">
        <div class="row">
            <table class="table table-striped table-borderless">
                <tr style="background-color: lightgreen;"><td colspan="2"><strong>Chi tiết đơn hàng</strong></td></tr>
                <tr><td>Ngày đặt hàng</td><td>{{ \Carbon\Carbon::parse($orderDetails['created_at'])->format('d/m/Y H:i:s') }}</td></tr>
                <tr><td>Trạng thái đơn hàng</td><td>{{$orderDetails['order_status']}}</td></tr>
                <tr><td>Tổng đơn hàng</td><td>{{number_format($orderDetails['grand_total'], 0, ',', '.')}} ₫</td></tr>
                <tr><td>Phí vận chuyển</td><td>{{$orderDetails['shipping_charges']}}</td></tr>
                @if($orderDetails['coupon_code']!="")
                <tr><td>Coupon</td><td>{{$orderDetails['coupon_code']}}</td></tr>
                <tr><td>Giảm giá</td><td>{{number_format($orderDetails['coupon_amount'], 0, ',', '.')}} ₫</td></tr>
                @endif
                @if($orderDetails['courier_name']!="")
                <tr><td>Đơn vị vận chuyển</td><td>{{$orderDetails['courier_name']}}</td></tr>
                <tr><td>Mã vận đơn</td><td>{{$orderDetails['tracking_number']}} </td></tr>
                @endif
                <tr><td>Phương thức thanh toán</td><td>{{$orderDetails['payment_method']}}</td></tr>
            </table><br>
            <table class="table table-striped table-borderless"> 
                <tr style="background-color: pink; color: white;">
                    <th>Hình sản phẩm</th>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Phân loại </th>
                    <th>Màu sắc</th>
                    <th>Số lượng</th>
                </tr>
                @foreach($orderDetails['orders_products'] as $product)
                <tr>
                    <td>
                        @php $getProductImage = Product::getProductImage($product['product_id']) @endphp
                        <a href="{{url('product/'.$product['product_id'])}}"> <img style="width: 80px;" src="{{ asset('front/images/product_images/small/'.$getProductImage)}}"></a>
                    </td>
                    <td>{{ $product['product_code'] }}</td>
                    <td>{{ $product['product_name'] }}</td>
                    <td>{{ $product['product_size'] }}</td>
                    <td>{{ $product['product_color'] }}</td>
                    <td>{{ $product['product_qty'] }}</td>
                </tr>
                @if($product['courier_name']!="")
                <tr><td colspan="6">Đơn vị vận chuyển: {{$product['courier_name']}},Mã vận đơn: {{$product['tracking_number']}}</td></tr>
                @endif
                @endforeach
            </table><br>
            <table class="table table-striped table-borderless">
                <tr style="background-color: yellow;"><td colspan="2"><strong>Chi tiết vận chuyển</strong></td></tr>
                <tr><td>Tên</td><td>{{$orderDetails['name']}}</td></tr>
                <tr><td>Địa chỉ</td><td>{{$orderDetails['address']}}</td></tr>
                <tr><td>Quận/Huyện</td><td>{{$orderDetails['state']}}</td></tr>
                <tr><td>Tỉnh/Thành phố</td><td>{{$orderDetails['city']}}</td></tr>
                <tr><td>Quốc gia</td><td>{{$orderDetails['country']}} ₫</td></tr>
                <tr><td>Mã vùng</td><td>{{$orderDetails['zipcode']}}</td></tr>
                <tr><td>Số điện thoại</td><td>{{$orderDetails['mobile']}}</td></tr>
            </table>
        </div>
    </div>
</div>
<!-- Cart-Page /- -->
@endsection
