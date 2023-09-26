@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Quản lý coupon</h3>
                        <h6 class="font-weight-normal mb-0">Cập nhật coupon</h6>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class "dropdown-item" href="#">March - June</a>
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
                  <h4 class="card-title">{{ $title }}</h4>
                    @if(Session::has('error_message'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Lỗi: </strong> {{ Session::get('error_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @endif

                    @if(Session::has('success_message'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Thành công: </strong> {{ Session::get('success_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="form-group">
                      <form class="forms-sample" @if(empty($coupon['id'])) action="{{ url('admin/add-edit-coupon') }}" @else action="{{ url('admin/add-edit-coupon/'.$coupon['id']) }}" @endif method="post" enctype="multipart/form-data" >
                        @csrf
                        @if(empty($coupon['coupon_code']))
                          <div class="form-group">
                              <label for="coupon_option">Lựa chọn:</label><br>
                              <span><input id="AutomaticCoupon" type="radio" name="coupon_option" value="Automatic" checked="">&nbsp;Tự động&nbsp;&nbsp;
                              <span><input id="ManualCoupon" type="radio" name="coupon_option" value="Manual">&nbsp;Thủ công&nbsp;&nbsp;
                          </div>
                          <div class="form-group">
                            <div class="form-group" style="display: none;" id="couponField">
                                <label for="coupon_code">Mã giảm giá</label>
                                <input type="text" class="form-control" name="coupon_code" placeholder="Nhập mã giảm giá" name="coupon_name">
                            </div>
                        @else
                          <input type="hidden" name="coupon_option" value="{{$coupon['coupon_option']}}">
                          <input type="hidden" name="coupon_code" value="{{$coupon['coupon_code']}}">
                          <div class="form-group">
                              <label for="coupon_code"> Mã giảm giá: </label>
                              <span>{{$coupon['coupon_code']}}</span>
                          </div>
                        @endif
                        <div class="form-group">
                          <label for="coupon_type">Loại coupon:</label><br>
                          <span><input  type="radio" name="coupon_type" value="Multiple Times"  @if(old('coupon_type', isset($coupon['coupon_type']) ? $coupon['coupon_type'] : '') == "Multiple Times") checked=""@endif >&nbsp;Dùng nhiều lần&nbsp;&nbsp;
                          <span><input  type="radio" name="coupon_type" value="Single Time" @if(old('coupon_type', isset($coupon['coupon_type']) ? $coupon['coupon_type'] : '') == "Single Time") checked=""@endif>&nbsp;Dùng một lần&nbsp;&nbsp;
                        </div>
                        <div class="form-group">
                            <label for="amount_type">Giảm giá theo:</label><br>
                            <span><input  type="radio" name="amount_type" value="Percentage" @if(old('amount_type', isset($coupon['amount_type']) ? $coupon['amount_type'] : '') == "Percentage") checked=""@endif>&nbsp;Phần trăm&nbsp;&nbsp;( %)
                            <span><input  type="radio" name="amount_type" value="Fixed" @if(old('amount_type', isset($coupon['amount_type']) ? $coupon['amount_type'] : '') == "Fixed") checked=""@endif>&nbsp;Số tiền&nbsp;( VND)
                        </div>
                        <div class="form-group">
                            <label for="amount">Số</label>
                            <input type="text" class="form-control" id="amount" placeholder="Nhập % hoặc số tiền" name="amount" value="{{ old('amount', isset($coupon['amount']) ? $coupon['amount'] : '') }}">
                        </div>

                        <label for="categories">Chọn phân loại</label>
                        <select name="categories[]"  class="form-control" style="color:darkcyan" multiple="">
                            @foreach($categories as $section)
                                <optgroup label="{{ $section['name'] }}"></optgroup>
                                @foreach($section['categories'] as $category)
                                    <option value="{{ $category['id'] }}" @if(in_array($category['id'],$selCats)) selected="" @endif>&nbsp;&nbsp;&nbsp;--&nbsp;{{$category['category_name']}}</option>
                                    @foreach($category['subcategories'] as $subcategory)
                                        <option value="{{ $subcategory['id'] }}"@if(in_array($subcategory['id'],$selCats)) selected="" @endif >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;{{$subcategory['category_name']}}</option>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                          <label for="brands">Chọn thương hiệu</label>
                          <select name="brands[]"  class="form-control" style="color:darkcyan" multiple="">
                            @foreach($brands as $brand)
                            <option   value="{{ $brand['id'] }}" @if(in_array($brand['id'],$selBrands)) selected="" @endif>{{ $brand['name'] }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="users">Chọn người dùng</label>
                          <select name="users[]" class="form-control" style="color:darkcyan" multiple="">
                            @foreach($users as $user)
                            <option   value="{{ $user['email'] }}" @if(in_array($user['email'],$selUsers)) selected="" @endif >{{ $user['email'] }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="expiry_date">Ngày hết hạn</label>
                          <input type="date" class="form-control" id="expiry_date" placeholder="Nhập ngày hết hạn" name="expiry_date" value="{{ old('expiry_date', isset($coupon['expiry_date']) ? $coupon['expiry_date'] : '') }}">
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Xác nhận</button>
                        <button type="reset" class="btn btn-light">Hủy</button>
                      </form>
                    </div>
                  </div>
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
