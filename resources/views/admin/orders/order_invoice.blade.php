<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Hóa đơn mua hàng</h2><h3 class="pull-right">Số: #{{ $orderDetails['id'] }}
                    <?php echo DNS1D::getBarcodeHTML($orderDetails['id'], 'C39'); ?>
                </h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Thông tin người gửi:</strong><br>
    					    <b>Tên:</b> {{$userDetails['name']}}<br>
                        @if(!empty($userDetails['address']))
                        <b>Địa chỉ:</b> {{$userDetails['address']}}<br>
                        @endif
                        @if(!empty($userDetails['state']))
                        <b>Quận/Huyện:</b> {{$userDetails['state']}}<br>
                        @endif
                        @if(!empty($userDetails['city']))
                        <b>Tỉnh/Thành phố:</b> {{$userDetails['city']}}<br>
                        @endif
                        @if(!empty($userDetails['country']))
                        <b>Quốc gia:</b> {{$userDetails['country']}}<br>
                        @endif
                        @if(!empty($userDetails['zipcode']))
                        <b>Mã vùng:</b> {{$userDetails['zipcode']}}<br>
                        @endif
                        @if(!empty($userDetails['mobile']))
                        <b>Số điện thoại:</b> {{$userDetails['mobile']}}<br>
                        @endif
    					
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Thông tin người nhận:</strong><br>
                    Tên: {{$orderDetails['name']}}<br>
                        @if(!empty($orderDetails['address']))
                        <b>Địa chỉ:</b> {{$orderDetails['address']}}<br>
                        @endif
                        @if(!empty($orderDetails['state']))
                        <b> Quận/Huyện:</b> {{$orderDetails['state']}}<br>
                        @endif
                        @if(!empty($orderDetails['city']))
                        <b>Tỉnh/Thành phố:</b> {{$orderDetails['city']}}<br>
                        @endif
                        @if(!empty($orderDetails['country']))
                        <b>Quốc gia:</b> {{$orderDetails['country']}}<br>
                        @endif
                        @if(!empty($orderDetails['zipcode']))
                        <b>Mã vùng:</b> {{$orderDetails['zipcode']}}<br>
                        @endif
                        @if(!empty($orderDetails['mobile']))
                        <b>Số điện thoại:</b> {{$orderDetails['mobile']}}<br>
                        @endif
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Phương thức thanh toán:</strong><br>
    					{{$orderDetails['payment_method']}}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Ngày đặt hàng:</strong><br>
    					{{ \Carbon\Carbon::parse($orderDetails['created_at'])->format('d/m/Y H:i:s') }}<br><br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Sản phẩm</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Mã sản phẩm</strong></td>
        							<td class="text-center"><strong>Phân loại</strong></td>
        							<td class="text-center"><strong>Màu sắc</strong></td>
        							<td class="text-center"><strong>Giá</strong></td>
        							<td class="text-center"><strong>Số lượng</strong></td>
        							<td class="text-right"><strong>Tổng</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
                                @php $subTotal =0 @endphp
                                @foreach($orderDetails['orders_products'] as $product)
    							<tr>
    								<td>{{$product['product_code']}}<?php echo DNS1D::getBarcodeHTML($product['product_code'], 'C39'); ?></td>
    								<td class="text-center">{{$product['product_size']}}</td>
    								<td class="text-center">{{$product['product_color']}}</td>
    								<td class="text-center">{{number_format($product['product_price'] , 0, ',', '.')}} ₫</td>
                                    <td class="text-center">{{$product['product_qty']}}</td>
                                    <td class="text-right">{{number_format($product['product_price']*$product['product_qty'] , 0, ',', '.')}} ₫</td>
    							</tr>
                                @php $subTotal = $subTotal + ($product['product_price']*$product['product_qty']) @endphp
                                @endforeach
                                
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-right"><strong>Tổng cộng</strong></td>
    								<td class="thick-line text-right">{{number_format($subTotal, 0, ',', '.')}} ₫</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Phí vận chuyển</strong></td>
    								<td class="no-line text-right">0 ₫</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Tổng hóa đơn</strong></td>
    								<td class="no-line text-right"><strong>{{number_format($orderDetails['grand_total'], 0, ',', '.')}} ₫</strong><br>
                                    @if($orderDetails['payment_method']=="COD")
                                    <font color=red>(Đã thanh toán)</font>
                                    @endif
                                </td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>