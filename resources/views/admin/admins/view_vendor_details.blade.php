@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Nhà cung cấp</h3>
                        <h6 class="font-weight-normal mb-0"><a href="{{ url('admin/admins/vendor') }}"> Quay lại nhà cung cấp</a></h6>
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
                  <h4 class="card-title">Thông tin cá nhân</h4>
                    <div class="form-group">
                      <label>Email</label>
                      <input  class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_name">Tên</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['name'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_address">Địa chỉ</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['address'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_city">Tỉnh/Thành phố</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['city'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_state">Quận/huyện</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['state'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_country">Quốc gia</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['country'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_zipcode">Mã Zip</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['zipcode'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_mobile">Số điện thoại</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['mobile'] }}" required="" maxlength="10" minlength="10" readonly="">
                    </div>
                    @if(!empty($vendorDetails['image']))
                    <div class="form-group">
                      <label for="vendor_image">Ảnh đại diện</label>
                      <br>
                      
                          <img style="width: 200px;" src="{{ url('admin/images/photos/'.$vendorDetails['image']) }}">
                          
                    </div>
                    @endif
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Thông tin doanh nghiệp</h4>
                    
                    <div class="form-group">
                      <label for="vendor_name">Tên Shop</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['shop_name'])) value="{{ $vendorDetails['shop_name'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_address">Địa chỉ Shop</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['shop_address'])) value="{{ $vendorDetails['shop_address'] }}"@endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_city">Tỉnh/Thành phố</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['shop_city'])) value="{{ $vendorDetails['shop_city'] }}"@endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_state">Quận/huyện</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['shop_state'])) value="{{ $vendorDetails['shop_state'] }}"@endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_country">Quốc gia</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['shop_country'])) value="{{ $vendorDetails['shop_country'] }}"@endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_zipcode">Mã Zip</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['shop_zipcode'])) value="{{ $vendorDetails['shop_zipcode'] }}"@endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_mobile">Số điện thoại</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['shop_mobile'])) value=" {{ $vendorDetails['shop_mobile'] }} " @endif required="" maxlength="10" minlength="10" readonly="">
                    </div>
                    <div class="form-group">
                      <label>Shop Website</label>
                      <input  class="form-control" @if(isset($vendorDetails['shop_website'])) value="{{ $vendorDetails['shop_website'] }}"@endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>Shop Email</label>
                      <input  class="form-control" @if(isset($vendorDetails['shop_email'])) value="{{ $vendorDetails['shop_email'] }}"@endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>Giấy tờ chứng minh</label>
                      <input  class="form-control" @if(isset($vendorDetails['address_proof'])) value="{{ $vendorDetails['address_proof'] }}"@endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>Số giấy phép kinh doanh</label>
                      <input  class="form-control" @if(isset($vendorDetails['business_license_number'])) value="{{ $vendorDetails['business_license_number'] }}"@endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>GST</label>
                      <input  class="form-control" @if(isset($vendorDetails['gst_number'])) value="{{ $vendorDetails['gst_number'] }}"@endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>PAN</label>
                      <input  class="form-control" @if(isset($vendorDetails['pan-number'])) value="{{ $vendorDetails['pan-number'] }}"@endif readonly="">
                    </div>
                    @if(!empty($vendorDetails['vendor_business']['address_proof_image']))
                    <div class="form-group">
                      <label for="vendor_image">Ảnh đại diện</label>
                      <br>
                      
                          <img style="width: 200px;" src="{{ url('admin/images/proofs/'.$vendorDetails['vendor_business']['address_proof_image']) }}">
                          
                    </div>
                    @endif
                    
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Thông tin ngân hàng</h4>
                    
                    <div class="form-group">
                      <label for="vendor_name">Tên tài khoản</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['account_holder_name'])) value="{{ $vendorDetails['account_holder_name'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_address">Tên ngân hàng</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['bank_name'])) value="{{ $vendorDetails['bank_name'] }}"@endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_city">Số tài khoản</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['account_number'])) value="{{ $vendorDetails['account_number'] }}"@endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_state">Mã code</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['bank_ifsc_code'])) value="{{ $vendorDetails['bank_ifsc_code'] }}"@endif readonly="">
                    </div>
                    
                  </form>
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