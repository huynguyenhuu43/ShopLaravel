@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">             
                        <h4 class="card-title">Các đơn hàng</h4>
                        <div class="table-responsive pt-3">
                            <table id="orders" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            ID đơn hàng
                                        </th>
                                        <th>
                                            Ngày đặt hàng
                                        </th>
                                        <th>
                                            Tên khách hàng
                                        </th>
                                        <th>
                                            Email khách hàng
                                        </th>
                                        <th>
                                            Sản phẩm đã mua
                                        </th>
                                        <th>
                                            Số tiền
                                        </th>
                                        
                                        <th>
                                            Trạng thái đơn hàng
                                        </th>
                                        <th>
                                            Phương thức thanh toán
                                        </th>
                                        <th>
                                            Chi tiết
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    @if($order['orders_products'])
                                    <tr>
                                        <td>
                                            {{ $order['id'] }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($order['created_at'])->format('d/m/Y H:i:s') }}
                                        </td>
                                        <td>
                                            {{ $order['name'] }}
                                        </td>
                                        <td>
                                            {{ $order['email'] }}
                                        </td>
                                        <td>
                                            @foreach($order['orders_products'] as $product)
                                                {{ $product['product_name']}} ({{$product['product_qty']}})<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ number_format($order['grand_total'] , 0, ',', '.')}} ₫
                                        </td>
                                        <td>
                                            {{ $order['order_status'] }}
                                        </td>
                                        <td>
                                            {{ $order['payment_method'] }}
                                        </td>
                                        <td>
                                            <a title="Xem chi tiết" href="{{url ('admin/orders/'.$order['id'] )}}"><i style="font-size: 25px;" class="mdi mdi-file-document"></i></a>
                                            &nbsp;&nbsp;
                                            <a target="_blank" title="Xem hóa đơn" href="{{url ('admin/orders/invoice/'.$order['id'] )}}"><i style="font-size: 25px;" class="mdi mdi-printer"></i></a>
                                            &nbsp;&nbsp;
                                            <a target="_blank" title="In hóa đơn" href="{{url ('admin/orders/invoice/pdf/'.$order['id'] )}}"><i style="font-size: 25px;" class="mdi mdi-file-pdf"></i></a>
                                        
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
        </div>
    </footer>
    <!-- partial -->
</div>
@endsection