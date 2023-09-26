@extends('front.layout.layout')
@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Đơn hàng của bạn</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{url('/')}}">Trang chủ</a>
                </li>
                <li class="is-marked">
                    <a href="#">Đơn hàng của bạn</a>
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
                <tr style="background-color: lightblue;">
                    <th>ID đơn hàng</th>
                    <th>Sản phẩm</th>
                    <th>Phương thức thanh toán</th>
                    <th>Tổng hóa đơn</th>
                    <th>Tạo lúc</th>
                </tr>
                @foreach($orders as $order)
                <tr>
                    <td><a href="{{ url('user/orders/'.$order['id']) }}"> {{$order['id']}} </a></td>
                    <td>
                        @foreach($order['orders_products'] as $product)
                            {{ $product['product_name']}}<br>
                        @endforeach
                    </td>
                    <td>{{$order['payment_method']}}</td>
                    <td>{{number_format($order['grand_total'], 0, ',', '.')}} ₫</td>
                    <td>{{ \Carbon\Carbon::parse($order['created_at'])->format('d/m/Y H:i:s') }}</td>
                    
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
<!-- Cart-Page /- -->
@endsection
