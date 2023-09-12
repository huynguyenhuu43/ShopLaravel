@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Cài đặt nhà cung cấp</h3>
                        <h6 class="font-weight-normal mb-0">Cập nhật chi tiết</h6>
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
        @if($slug=="personal")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Cập nhật thông tin cá nhân</h4>
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
                
                @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/personal') }}" method="post" enctype="multipart/form-data" >@csrf
                    <div class="form-group">
                      <label>Email</label>
                      <input  class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_name">Tên</label>
                      <input type="text" class="form-control" id="vendor_name" placeholder="Nhập tên của bạn" name="vendor_name" value="{{ Auth::guard('admin')->user()->name }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_address">Địa chỉ</label>
                      <input type="text" class="form-control" id="vendor_address" placeholder="Nhập địa chỉ của bạn" name="vendor_address" value="{{ $vendorDetails['address'] }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_city">Tỉnh/Thành phố</label>
                      <input type="text" class="form-control" id="vendor_city" placeholder="Nhập tỉnh hoặc thành phố" name="vendor_city" value="{{ $vendorDetails['city'] }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_state">Quận/huyện</label>
                      <input type="text" class="form-control" id="vendor_state" placeholder="Nhập quận/huyện của bạn" name="vendor_state" value="{{ $vendorDetails['state'] }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_country">Quốc gia</label>
                      <input type="text" class="form-control" id="vendor_country" placeholder="Nhập quốc gia của bạn" name="vendor_country" value="{{ $vendorDetails['country'] }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_zipcode">Mã Zip</label>
                      <input type="text" class="form-control" id="vendor_zipcode" placeholder="Nhập tên của bạn" name="vendor_zipcode" value="{{ $vendorDetails['zipcode'] }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_mobile">Số điện thoại</label>
                      <input type="text" class="form-control" id="vendor_mobile" placeholder="Nhập số điện thoại" name="vendor_mobile" value="{{ Auth::guard('admin')->user()->mobile }}" required="" maxlength="10" minlength="10">
                    </div>
                    <div class="form-group">
                      <label for="vendor_image">Ảnh đại diện</label>
                      <input type="file" class="form-control" id="vendor_image"  name="vendor_image"   >
                      @if(!empty(Auth::guard('admin')->user()->image))
                      <a target="_blank" href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image) }}">Xem hình</a>
                      <input type="hidden" name="current_vendor_image" value="{{ Auth::guard('admin')->user()->image }}">
                      @endif
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Xác nhận</button>
                    <button type="reset" class="btn btn-light">Hủy</button>
                  </form>
                </div>
              </div>
            </div>
            
          </div>
        @elseif($slug=="business")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Cập nhật thông tin doanh nghiệp</h4>
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
                
                @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/business') }}" method="post" enctype="multipart/form-data" >@csrf
                    <div class="form-group">
                      <label>Email</label>
                      <input  class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="shop_name">Tên Shop</label>
                      <input type="text" class="form-control" id="shop_name" placeholder="Nhập tên shop của bạn" name="shop_name" value="{{ $vendorDetails['shop_name'] }}">
                    </div>
                    <div class="form-group">
                      <label for="shop_address">Địa chỉ Shop</label>
                      <input type="text" class="form-control" id="shop_address" placeholder="Nhập địa chỉ shop của bạn" name="shop_address" value="{{ $vendorDetails['shop_address'] }}">
                    </div>
                    <div class="form-group">
                      <label for="shop_city">Tỉnh/Thành phố</label>
                      <input type="text" class="form-control" id="shop_city" placeholder="Nhập tỉnh hoặc thành phố" name="shop_city" value="{{ $vendorDetails['shop_city'] }}">
                    </div>
                    <div class="form-website
                      <label for="shop_state">Quận/huyện</label>
                      <input type="text" class="form-control" id="shop_state" placeholder="Nhập quận/huyện của bạn" name="shop_state" value="{{ $vendorDetails['shop_state'] }}">
                    </div>
                    <div class="form-group">
                      <label for="shop_country">Quốc gia</label>
                      <input type="text" class="form-control" id="shop_country" placeholder="Nhập quốc gia của bạn" name="shop_country" value="{{ $vendorDetails['shop_country'] }}">
                    </div>
                    <div class="form-group">
                      <label for="shop_zipcode">Mã Zip</label>
                      <input type="text" class="form-control" id="shop_zipcode" placeholder="Nhập mã vùng" name="shop_zipcode" value="{{ $vendorDetails['shop_zipcode'] }}">
                    </div>
                    <div class="form-group">
                      <label for="shop_mobile">Số điện thoại</label>
                      <input type="text" class="form-control" id="shop_mobile" placeholder="Nhập số điện thoại" name="shop_mobile" value=" {{ $vendorDetails['shop_mobile'] }} " required="" maxlength="10" minlength="10">
                    </div>
                    <div class="form-group">
                      <label for="business_license_number">Số giấy phép kinh doanh</label>
                      <input type="text" class="form-control" id="business_license_number" placeholder="Nhập số giấy phép kinh doanh" name="business_license_number" value="{{ $vendorDetails['business_license_number'] }}">
                    </div>
                    <div class="form-group">
                      <label for="gst_number">GTS</label>
                      <input type="text" class="form-control" id="gst_number" placeholder="Nhập GTS" name="gst_number" value="{{ $vendorDetails['gst_number'] }}">
                    </div>
                    <div class="form-group">
                      <label for="pan-number">PAN</label>
                      <input type="text" class="form-control" id="pan-number" placeholder="Nhập PAN" name="pan-number" value="{{ $vendorDetails['pan-number'] }}">
                    </div>
                    <div class="form-group">
                      <label for="address_proof">Giấy tờ chứng minh</label>
                      <select class="form-control" name="address_proof" id="address_proof">
                        <option value="CCCD" @if($vendorDetails['address_proof']=="CCCD") selected @endif>Căn cước công dân</option>
                        <option value="SHK" @if($vendorDetails['address_proof']=="SHK") selected @endif>Sổ hộ khẩu</option>
                        <option value="HC" @if($vendorDetails['address_proof']=="HC") selected @endif>Hộ chiếu</option>
                        <option value="GPLX" @if($vendorDetails['address_proof']=="GPLX") selected @endif>Giấy phép lái xe</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="address_proof_image">Hình ảnh giấy tờ chứng minh</label>
                      <input type="file" class="form-control" id="address_proof_image"  name="address_proof_image">
                      @if(!empty($vendorDetails['address_proof_image']))
                      <a target="_blank" href="{{ url('admin/images/proofs/'.$vendorDetails['address_proof_image']) }}">Xem hình</a>
                      <input type="hidden" name="current_address_proof" value="{{ $vendorDetails['address_proof_image'] }}">
                      @endif
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Xác nhận</button>
                    <button type="reset" class="btn btn-light">Hủy</button>
                  </form>
                </div>
              </div>
            </div>
            
          </div>
        @elseif($slug=="bank")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Cập nhật thông tin ngân hàng</h4>
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
                
                @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/bank') }}" method="post" enctype="multipart/form-data" >@csrf
                    <div class="form-group">
                      <label>Email</label>
                      <input  class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="account_holder_name">Tên tài khoản</label>
                      <input type="text" class="form-control" id="account_holder_name" placeholder="Nhập Tên tài khoản" name="account_holder_name" value="{{ $vendorDetails['account_holder_name'] }}">
                    </div>
                    <div class="form-group">
                      <label for="bank_name">Tên ngân hàng</label>
                      <input type="text" class="form-control" id="bank_name" placeholder="Nhập Tên ngân hàng" name="bank_name" value="{{ $vendorDetails['bank_name'] }}">
                    </div>
                    <div class="form-group">
                      <label for="account_number">Số tài khoản</label>
                      <input type="text" class="form-control" id="account_number" placeholder="Nhập Số tài khoản" name="account_number" value="{{ $vendorDetails['account_number'] }}">
                    </div>
                    <div class="form-group">
                      <label for="bank_ifsc_code">Mã Code</label>
                      <input type="text" class="form-control" id="bank_ifsc_code" placeholder="Nhập Mã Code" name="bank_ifsc_code" value="{{ $vendorDetails['bank_ifsc_code'] }}">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Xác nhận</button>
                    <button type="reset" class="btn btn-light">Hủy</button>
                  </form>
                </div>
              </div>
            </div>
            
          </div>
        @endif
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>

@endsection