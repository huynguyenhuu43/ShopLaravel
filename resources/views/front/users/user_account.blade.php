@extends('front.layout.layout')
@section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Account</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="account.html">Account</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Account-Page -->
    <div class="page-account u-s-p-t-80">
        <div class="container">
        @if(Session::has('success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Thành công: </strong> {{ Session::get('success_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            @endif
            @if(Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Lỗi: </strong> {{ Session::get('error_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Lỗi: </strong><?php echo implode('',$errors->all('<div>:message</div>')); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            @endif
            <div class="row">
                <!-- account -->
                <div class="col-lg-6">
                    <div class="account-wrapper">
                        <h2 class="account-h2 u-s-m-b-20" >Cập nhật chi tiết</h2>
            
                        <p id="account-error"></p>
                        <p id="account-success"></p>
                        <form id="accountForm" action="javascript:;" method="post">@csrf
                            <div class="u-s-m-b-30">
                                <label for="user-email">Email
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" value="{{ Auth::user()->email }}" readonly="" disabled="" style="background-color:#e9e9e9;">
                                <p id="account-email"></p>
                            </div>

                            <div class="u-s-m-b-30">
                                <label for="user-name">Tên
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-name" name="name" value="{{ Auth::user()->name }}" placeholder="Nhập tên của bạn">
                                <p id="account-name"></p>
                            </div>

                            <div class="u-s-m-b-30">
                                <label for="user-address">Địa chỉ
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-address" name="address" value="{{ Auth::user()->address }}" placeholder="Nhập địa chỉ của bạn">
                                <p id="account-address"></p>
                            </div>

                            <div class="u-s-m-b-30">
                                <label for="user-city">Tỉnh/Thành phố
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-city" name="city" value="{{ Auth::user()->city }}" placeholder="Nhập thành phố của bạn">
                                <p id="account-city"></p>
                            </div>

                            <div class="u-s-m-b-30">
                                <label for="user-state">Quận/Huyện
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-state" name="state" value="{{ Auth::user()->state }}" placeholder="Nhập quận/huyện của bạn">
                                <p id="account-state"></p>
                            </div>

                            <div class="u-s-m-b-30">
                                <label for="user-country">Quốc gia
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-country" name="country" value="{{ Auth::user()->country }}" placeholder="Nhập quốc gia của bạn">
                                <p id="account-country"></p>
                            </div>

                            <div class="u-s-m-b-30">
                                <label for="user-zipcode">Zipcode
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-zipcode" name="zipcode" value="{{ Auth::user()->zipcode }}" placeholder="Nhập mã zip của bạn">
                                <p id="account-zipcode"></p>
                            </div>

                            <div class="u-s-m-b-30">
                                <label for="user-mobile">Số điện thoại
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-mobile" name="mobile" value="{{ Auth::user()->mobile }}" placeholder="Nhập số diện thoại của bạn">
                                <p id="account-mobile"></p>
                            </div>
                           
                            <div class="m-b-45">
                                <button class="button button-outline-secondary w-100">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- account /- -->
                <!-- doi mk -->
                <div class="col-lg-6">
                    <div class="reg-wrapper">
                        <h2 class="account-h2 u-s-m-b-20">Đổi mật khẩu</h2>
                        <p id="password-success"></p>
                        <p id="password-error"></p>
                        <form id="passwordForm" action="javascript:;" method="post">@csrf
                            <div class="u-s-m-b-30">
                                <label for="current-password">Mật khẩu cũ
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="current-password" name="current_password" class="text-field" placeholder="Nhập mật khẩu cũ">
                                <p id="password-current_password"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="usermobile">Mật khẩu mới
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="new-password" name="new_password" class="text-field" placeholder="Nhập mật khẩu cũ">
                                <p id="password-new_password"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="useremail">Xác nhận mật khẩu mới
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="confirm-password" name="confirm_password" class="text-field" placeholder="Nhập mật khẩu cũ">
                                <p id="password-confirm_password"></p>
                            </div>
                            
                            <div class="u-s-m-b-45">
                                <button class="button button-primary w-100">Đổi mật khẩu</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- doi mk /- -->
            </div>
        </div>
    </div>
    <!-- Account-Page /- -->
@endsection