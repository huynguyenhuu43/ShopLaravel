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
                    <button class="btn btn-light">Hủy</button>
                  </form>
                </div>
              </div>
            </div>
            
          </div>
        @elseif($slug=="business")

        @elseif($slug=="bank")

        @endif
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>

@endsection