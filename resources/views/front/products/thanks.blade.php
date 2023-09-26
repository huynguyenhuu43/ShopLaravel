<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Cart</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="index.html">Home</a>
                </li>
                <li class="is-marked">
                    <a href="#">Cảm ơn</a>
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
            <div class="col-lg-12 text-center">
                <h3 style="color: #4CAF50; font-size: 24px; font-weight: bold;">CẢM ƠN BẠN ĐÃ ĐẶT HÀNG CỦA CHÚNG TÔI</h3>
                <p style="font-size: 18px;">Đơn hàng của bạn có số đặt hàng là <span style="color: #4CAF50; font-weight: bold;">{{Session::get('order_id')}}</span> và tổng số tiền bạn cần thanh toán là <span style="color: #4CAF50; font-weight: bold;">{{number_format(Session::get('grand_total'), 0, ',', '.')}} ₫</span></p>
                <img style="max-width: 1000px;max-height:700px" src="{{asset('front/images/Thank You Cards Printable Thank You Cards Boho Style Thank - Etsy.jpg') }}" alt="">
            </div>
        </div>
    </div>
</div>
<!-- Cart-Page /- -->
@endsection
