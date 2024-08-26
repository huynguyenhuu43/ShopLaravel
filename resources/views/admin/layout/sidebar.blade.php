<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a @if(Session::get('page')=="dashboard") style="background: #4B49AC !important; color:#fff !important; " @endif class="nav-link" href="{{ url('admin/dashboard') }}">
            <i class="icon-grid menu-icon"></i>
            <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @if(Auth::guard('admin')->user()->type=="vendor")
        <li class="nav-item">
            <a @if(Session::get('page')=="update_personal_details") || Session::get('page')=="update_business_details") || Session::get('page')=="update_bank_details") style="background:#4B49AC !important; color:#fff !important; " @endif class="nav-link" data-toggle="collapse" href="#ui-vendors" aria-expanded="false" aria-controls="ui-vendors">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Chi tiết nhà cung cấp</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-vendors">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color:#4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="update_personal_details") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/update-vendor-details/personal') }}">Thông tin cá nhân</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="update_business_details") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/update-vendor-details/business') }}">Chi tiết kinh doanh</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="update_bank_details") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/update-vendor-details/bank') }}">Thông tin ngân hàng</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="products") ||Session::get('page')=="coupons") style="background:#4B49AC !important; color:#fff !important; " @endif class="nav-link" data-toggle="collapse" href="#ui-catalogue" aria-expanded="false" aria-controls="ui-catalogue">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Quản lý sản phẩm</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-catalogue">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color:#4B49AC !important;">                 
                    <li class="nav-item"> <a @if(Session::get('page')=="products") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/products') }}">Sản phẩm</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="coupons") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/coupons') }}">Coupon</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="orders") style="background:#4B49AC !important; color:#fff !important; " @endif class="nav-link" data-toggle="collapse" href="#ui-orders" aria-expanded="false" aria-controls="ui-orders">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Quản lý đơn hàng</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-orders" >
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color:#4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="orders") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/orders') }}">Đơn hàng</a></li>
                </ul>
            </div>
        </li>
        @else
        <li class="nav-item">
            <a @if(Session::get('page')=="update_admin_password") || Session::get('page')=="update_admin_details") style="background:#4B49AC !important; color:#fff !important; " @endif class="nav-link" data-toggle="collapse" href="#ui-settings" aria-expanded="false" aria-controls="ui-settings">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Cài đặt Admin</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-settings">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color:#4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="update_admin_password") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/update-admin-password') }}">Cập nhật mật khẩu</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="update_admin_details") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/update-admin-details') }}">Cập nhật chi tiết</a></li>
                    
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="view_admins") || Session::get('page')=="view_subadmins") || Session::get('page')=="view_vendors") || Session::get('page')=="view_all") style="background:#4B49AC !important; color:#fff !important; " @endif class="nav-link" data-toggle="collapse" href="#ui-admins" aria-expanded="false" aria-controls="ui-admins">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Quản lý Admin</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-admins">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color:#4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="view_admins") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/admins/admin') }}">Quản trị viên</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="view_subadmins") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/admins/subadmin') }}">Quản trị viên phụ</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="view_vendors") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/admins/vendor') }}">Nhà cung cấp</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="view_all") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/admins') }}">Tất cả</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="sections") || Session::get('page')=="categories") || Session::get('page')=="products") || Session::get('page')=="coupons") ||Session::get('page')=="filters") style="background:#4B49AC !important; color:#fff !important; " @endif class="nav-link" data-toggle="collapse" href="#ui-catalogue" aria-expanded="false" aria-controls="ui-catalogue">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Quản lý danh mục</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-catalogue">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color:#4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="sections") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/sections') }}">Danh mục</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="categories") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/categories') }}">Phân loại</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="brands") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/brands') }}">Thương hiệu</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="products") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/products') }}">Sản phẩm</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="coupons") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/coupons') }}">Coupon</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="filters") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/filters') }}">Bộ lọc</a></li>
                </ul>
            </div>
        </li>
        <<li class="nav-item">
            <a @if(Session::get('page')=="users") || Session::get('page')=="subscribers") style="background:#4B49AC !important; color:#fff !important; " @endif class="nav-link" data-toggle="collapse" href="#ui-users" aria-expanded="false" aria-controls="ui-users">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Quản lý người dùng</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id"ui-users" >
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color:#4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="users") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/users') }}">Users</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="subscribers") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/subcbrice') }}">Người đăng kí</a></li>
                </ul>
            </div>
        </li> 
        <li class="nav-item">
            <a @if(Session::get('page')=="orders") style="background:#4B49AC !important; color:#fff !important; " @endif class="nav-link" data-toggle="collapse" href="#ui-orders" aria-expanded="false" aria-controls="ui-orders">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Quản lý đơn hàng</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-orders" >
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color:#4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="orders") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/orders') }}">Đơn hàng</a></li>
                </ul>
            </div>
        </li>
         <li class="nav-item">
            <a @if(Session::get('page')=="ratings") style="background:#4B49AC !important; color:#fff !important; " @endif class="nav-link" data-toggle="collapse" href="#ui-ratings" aria-expanded="false" aria-controls="ui-ratings">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Quản lý đánh giá</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-ratings" >
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color:#4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="ratings") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/ratings') }}">Đánh giá</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="banners") style="background:#4B49AC !important; color:#fff !important; " @endif class="nav-link" data-toggle="collapse" href="#ui-banners" aria-expanded="false" aria-controls="ui-banners">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Quản lý Banner</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-banners">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color:#4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="banners") style="background: #4B49AC !important; color:#fff !important; " @else style="background: #fff !important; color:#4B49AC !important; "  @endif class="nav-link" href="{{ url('admin/banners') }}">Banners chính</a></li>                    
                </ul>
            </div>
        </li> 
        @endif
        
    </ul>
</nav>