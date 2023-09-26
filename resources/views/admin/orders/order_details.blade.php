<?php use App\Models\Product; use App\Models\OrdersLog; ?>
@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
    @if(Session::has('success_message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Thành công: </strong> {{ Session::get('success_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Chi tiết đơn hàng </h3>
                        <h6 class="font-weight-normal mb-0"><a href="{{ url('admin/orders') }}"> Quay lại đơn hàng</a></h6>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Chi tiết đơn hàng</h4>
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">ID: </label>
                      <label>#{{$orderDetails['id']}}</label>
                    </div>
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Ngày đặt hàng: </label>
                      <label>{{ \Carbon\Carbon::parse($orderDetails['created_at'])->format('d/m/Y H:i:s') }}</label>
                    </div>
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Tổng đơn hàng: </label>
                      <label>{{number_format($orderDetails['grand_total'], 0, ',', '.')}} ₫</label>
                    </div>
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Trạng thái đơn hàng: </label>
                      <label>{{$orderDetails['order_status']}}</label>
                    </div>
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Phí vận chuyển: </label>
                      <label>{{$orderDetails['shipping_charges']}}₫</label>
                    </div>
                    @if(!empty($orderDetails['coupon_code']))
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Mã giảm giá: </label>
                      <label>{{$orderDetails['coupon_code']}}</label>
                    </div>
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Số tiền giảm: </label>
                      <label>{{number_format($orderDetails['coupon_amount'], 0, ',', '.')}} ₫</label>
                    </div>
                    @endif
                    
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Phương thức thanh toán: </label>
                      <label>{{$orderDetails['payment_method']}}</label>
                    </div>
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Thanh toán qua: </label>
                      <label>{{$orderDetails['payment_gateway']}}</label>
                    </div>
                    
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Thông tin khách hàng</h4>
                  <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Tên: </label>
                      <label>{{$userDetails['name']}}</label>
                    </div>
                    @if(!empty($userDetails['address']))
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Địa chỉ: </label>
                      <label>{{$userDetails['address']}}</label>
                    </div>
                    @endif
                    @if(!empty($userDetails['state']))
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Quận/huyện: </label>
                      <label>{{$userDetails['state']}}</label>
                    </div>
                    @endif
                    @if(!empty($userDetails['city']))
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Thành phố: </label>
                      <label>{{$userDetails['city']}}</label>
                    </div>
                    @endif
                    @if(!empty($userDetails['country']))
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Quốc tịch: </label>
                      <label>{{$userDetails['country']}}</label>
                    </div>
                    @endif
                    @if(!empty($userDetails['zipcode']))
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Mã vùng: </label>
                      <label>{{$userDetails['zipcode']}}</label>
                    </div>
                    @endif
                    @if(!empty($userDetails['mobile']))
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Số điện thoại: </label>
                      <label>{{$userDetails['mobile']}}</label>
                    </div>
                    @endif
                    @if(!empty($userDetails['email']))
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Email: </label>
                      <label>{{$userDetails['email']}}</label>
                    </div>
                    @endif
                    
                    
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Thông tin vận chuyển</h4>
                  <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Tên: </label>
                      <label>{{$orderDetails['name']}}</label>
                    </div>
                    @if(!empty($orderDetails['address']))
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Địa chỉ: </label>
                      <label>{{$orderDetails['address']}}</label>
                    </div>
                    @endif
                    @if(!empty($orderDetails['state']))
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Quận/huyện: </label>
                      <label>{{$orderDetails['state']}}</label>
                    </div>
                    @endif
                    @if(!empty($orderDetails['city']))
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Thành phố: </label>
                      <label>{{$orderDetails['city']}}</label>
                    </div>
                    @endif
                    @if(!empty($orderDetails['country']))
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Quốc tịch: </label>
                      <label>{{$orderDetails['country']}}</label>
                    </div>
                    @endif
                    @if(!empty($orderDetails['zipcode']))
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Mã vùng: </label>
                      <label>{{$orderDetails['zipcode']}}</label>
                    </div>
                    @endif
                    @if(!empty($orderDetails['mobile']))
                    <div class="form-group" style="height: 15px;">
                      <label style="font-weight: 550;">Số điện thoại: </label>
                      <label>{{$orderDetails['mobile']}}</label>
                    </div>
                    @endif
                    
                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Cập nhật trạng thái đơn hàng</h4>
                  @if(Auth::guard('admin')->user()->type!="vendor")
                    <form action="{{ url('admin/update-order-status') }}" method="post">@csrf
                      <input type="hidden" name="order_id" value="{{$orderDetails['id']}}">
                      <select name="order_status" id="order_status" required="">
                        <option value="" selected="">Chọn</option>
                        @foreach($orderStatuses as $status)
                        <option value="{{$status['name']}}" @if(!empty($orderDetails['order_status']) && $orderDetails['order_status']==$status['name']) selected="" @endif>{{$status['name']}}</option>
                        @endforeach
                      </select>
                      <input type="text" name="courier_name" id="courier_name" placeholder="ĐVVC">
                      <input type="text" name="tracking_number" id="tracking_number" placeholder="Mã vận đơn">
                      <button type="submit">Cập nhật </button>
                    </form>
                    <br>
                    @foreach($orderLog as $key => $log)
                    <?php //echo"<pre>"; print_r($log['orders_products'][$key]['product_code']); die; ?>
                    <strong>{{$log['order_status']}}</strong>
                    @if($log['order_status']=="Shipped")
                    @if(isset($log['order_item_id'])&&$log['order_item_id']>0)
                    @php $getItemDetails = OrdersLog::getItemDetails($log['order_item_id']) @endphp
                      - sản phẩm: {{$getItemDetails['product_code']}}
                      @if(!empty($getItemDetails['courier_name']))
                      <br><span>Đvvc: {{$getItemDetails['courier_name']}}</span>
                      @endif
                      @if(!empty($getItemDetails['tracking_number']))
                      <br><span>Mã vận đơn: {{$getItemDetails['tracking_number']}}</span>
                      @endif
                    @else
                      @if(!empty($orderDetails['courier_name']))
                      <br><span>Đvvc: {{$orderDetails['courier_name']}}</span>
                      @endif
                      @if(!empty($orderDetails['tracking_number']))
                      <br><span>Mã vận đơn: {{$orderDetails['tracking_number']}}</span>
                      @endif
                    @endif
                    @endif
                    <br>{{ \Carbon\Carbon::parse($log['created_at'])->format('d/m/Y H:i:s') }}<br>
                    <hr>
                    @endforeach
                    @else
                    This feature id restricted.
                    @endif 
                </div>
              </div>
            </div>

            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Sản phẩm đặt hàng</h4>
                  <table class="table table-striped table-borderless"> 
                <tr style="background-color: pink; color: white;">
                    <th>Hình sản phẩm</th>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Phân loại </th>
                    <th>Màu sắc</th>
                    <th>Số lượng</th>
                    <th>Trạng thái</th>
                </tr>
                @foreach($orderDetails['orders_products'] as $product)
                <tr>
                    <td>
                        @php $getProductImage = Product::getProductImage($product['product_id']) @endphp
                        <a href="{{url('product/'.$product['product_id'])}}"> <img style="width: 60px; height:40px" src="{{ asset('front/images/product_images/small/'.$getProductImage)}}"></a>
                    </td>
                    <td>{{ $product['product_code'] }}</td>
                    <td>{{ $product['product_name'] }}</td>
                    <td>{{ $product['product_size'] }}</td>
                    <td>{{ $product['product_color'] }}</td>
                    <td>{{ $product['product_qty'] }}</td>
                    <td>
                      <form action="{{ url('admin/update-order-item-status') }}" method="post">@csrf
                        <input type="hidden" name="order_item_id" value="{{$product['id']}}">
                        <select name="item_status" id="item_status" required="">
                          <option value="">Chọn</option>
                          @foreach($orderItemStatuses as $status)
                          <option value="{{$status['name']}}" @if(!empty($product['item_status']) && $product['item_status']==$status['name']) selected="" @endif>{{$status['name']}}</option>
                          @endforeach
                        </select>
                        <input style="width: 100px;" type="text" name="item_courier_name" id="item_courier_name" placeholder="ĐVVC" @if(!empty($product['courier_name'])) value="{{$product['courier_name']}}" @endif>
                        <input style="width: 100px;" type="text" name="item_tracking_number" id="item_tracking_number" placeholder="Mã vận đơn" @if(!empty($product['tracking_number'])) value="{{$product['tracking_number']}}" @endif>
                        <button type="submit">Cập nhật </button>
                      </form>
                    </td>
                </tr>
                @endforeach
            </table><br>
                </div>
              </div>
            </div>
          </div>
        
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>

@endsection