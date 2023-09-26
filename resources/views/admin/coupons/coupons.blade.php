@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        
                        <h4 class="card-title">Mã giảm giá</h4>
                        <a style="max-width: 170px; float: right; display:inline-block;" href="{{ url('admin/add-edit-coupon') }}" class="btn btn-block btn-primary">Thêm mã giảm giá</a>
                        @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Thành công: </strong> {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <div class="table-responsive pt-3">
                            <table id="coupons" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Mã giãm giá
                                        </th>
                                        <th>
                                            Loại
                                        </th>
                                        <th>
                                            Số lượng
                                        </th>
                                        <th>
                                            Ngày hết hạn
                                        </th>
                                        <th>
                                            Trạng thái
                                        </th>
                                        <th>
                                            Hoạt động
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($coupons as $coupon)
                                    <tr>
                                        <td>
                                            {{ $coupon['id'] }}
                                        </td>
                                        <td>
                                            {{ $coupon['coupon_code'] }}
                                        </td>
                                        <td>
                                            {{ $coupon['coupon_type'] }}
                                        </td>
                                        <td>
                                            <!-- da sua doi -->
                                            @if($coupon['amount_type']=="Percentage")
                                             {{ $coupon['amount'] }} %
                                            @else
                                            {{ number_format($coupon['amount'], 0, ',', '.') }} ₫
                                            @endif 
                                        </td>
                                        <td>
                                            {{ $coupon['expiry_date'] }}
                                        </td>
                                        <td>
                                            @if($coupon['status']==1)
                                            <a class="updateCouponStatus" id="coupon-{{ $coupon['id'] }}" coupon_id="{{ $coupon['id'] }}" href="javascript:void(0)"><i style="font-size: 25px;" class="mdi mdi-bookmark-check" status="Active"></i></a>
                                            @else
                                            <a class="updateCouponStatus" id="coupon-{{ $coupon['id'] }}" coupon_id="{{ $coupon['id'] }}" href="javascript:void(0)"><i style="font-size: 25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i></a>
                                            @endif 
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/add-edit-coupon/'.$coupon['id']) }}"><i style="font-size: 25px;" class="mdi mdi-pencil-box"></i></a>
                                            <a href="javascript:void(0)" class="confirmDelete" module="coupon" moduleid="{{ $coupon['id'] }}" ><i style="font-size: 25px;" class="mdi mdi-file-excel-box"></i></a>
                                        </td>
                                    </tr>
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