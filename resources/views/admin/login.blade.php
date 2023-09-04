<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Skydash Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ url('admin/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ url('admin/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ url('admin/vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ url('admin/css/vertical-layout-light/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ url('admin/images/favicon.png') }}" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="{{ url('admin/images/logo.svg') }}" alt="logo">
              </div>
              <h4>Chào mừng đến với trang quản trị.</h4>
              <h6 class="font-weight-light">Đăng nhập để tiếp tục.</h6>
              @if(Session::has('error_message'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Lỗi: </strong> Tài khoản hoặc mật khẩu không chính xác !
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

              <form class="pt-3" action="{{ url('admin/login') }}" method="post">@csrf
                <div class="form-group">
                  <input type="text" name="email" id="email" class="form-control form-control-lg" id
                  ="exampleInputEmail1" placeholder="Username" >
                </div>
                <div class="form-group">
                  <input type="password" name="password" id="password" class="form-control form-control-lg" id
                  ="exampleInputPassword1" placeholder="Password" >
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium 
                  auth-form-btn">ĐĂNG NHẬP</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Nhớ tài khoản
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Quên mật khẩu ?</a>
                </div>
                <div class="mb-2">
                  <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="ti-facebook mr-2"></i>Đăng nhập với facebook
                  </button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Bạn chưa có tài khoản ? <a href="register.html" class="text-primary">Tạo tài khoản</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{ url('js/off-canvas.js') }}"></script>
  <script src="{{ url('js/hoverable-collapse.js') }}"></script>
  <script src="{{ url('js/template.js') }}"></script>
  <script src="{{ url('js/settings.js') }}"></script>
  <script src="{{ url('js/todolist.js') }}"></script>
  <!-- endinject -->
</body>

</html>
