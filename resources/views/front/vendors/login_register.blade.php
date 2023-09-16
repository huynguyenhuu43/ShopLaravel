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
                <!-- Login -->
                <div class="col-lg-6">
                    <div class="login-wrapper">
                        <h2 class="account-h2 u-s-m-b-20">Đăng nhập</h2>
                        <h6 class="account-h6 u-s-m-b-30">Chào mừng trở lại! Đăng nhập vào tài khoản của bạn.</h6>
                        <form action="{{ url('admin/login') }}" method="post">@csrf
                            <div class="u-s-m-b-30">
                                <label for="vendor-email">Tên người dùng hoặc email
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" name="email" id="vendor-email" class="text-field" placeholder="Username / Email">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendor-password">Mật khẩu
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" name="password" id="vendor-password" class="text-field" placeholder="Password">
                            </div>
                            <!-- <div class="group-inline u-s-m-b-30">
                                <div class="group-1">
                                    <input type="checkbox" class="check-box" id="remember-me-token">
                                    <label class="label-text" for="remember-me-token">Nhớ tài khoản</label>
                                </div>
                                <div class="group-2 text-right">
                                    <div class="page-anchor">
                                        <a href="lost-password.html">
                                            <i class="fas fa-circle-o-notch u-s-m-r-9"></i>Quên mật khẩu?</a>
                                    </div>
                                </div>
                            </div> -->
                            <div class="m-b-45">
                                <button class="button button-outline-secondary w-100">Đăng nhập</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Login /- -->
                <!-- Register -->
                <div class="col-lg-6">
                    <div class="reg-wrapper">
                        <h2 class="account-h2 u-s-m-b-20">Đăng kí</h2>
                        <h6 class="account-h6 u-s-m-b-30">Đăng ký trang web này cho phép bạn truy cập trạng thái và lịch sử đơn hàng của mình.</h6>
                        <form id="vendorForm" action="{{ url('/vendor/register') }}" method="post">@csrf
                            <div class="u-s-m-b-30">
                                <label for="vendorname">Tên
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="vendorname" name="name" class="text-field" placeholder="Tên nhà cung cấp">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendormobile">Số điện thoại
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="vendormobile" name="mobile" class="text-field" placeholder="Số điện thoại nhà cung cấp">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendoremail">Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="email" id="vendoremail" name="email" class="text-field" placeholder="Email nhà cung cấp">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendorpassword">Mật khẩu
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="vendorpassword" name="password" class="text-field" placeholder="Password">
                            </div>
                            <div class="u-s-m-b-30">
                                <input type="checkbox" class="check-box" id="accept" name="accept">
                                <label class="label-text no-color" for="accept">Tôi đã đọc và chấp nhận
                                    <a href="terms-and-conditions.html" class="u-c-brand">điều khoản và điều kiện</a>
                                </label>
                            </div>
                            <div class="u-s-m-b-45">
                                <button class="button button-primary w-100">Đăng kí</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Register /- -->
            </div>
        </div>
    </div>
    <!-- Account-Page /- -->
@endsection