<?php
use App\Models\Section;
$sections = Section::sections();
$totalCartItems =totalCartItems();
?>
<!-- Header -->
<header>
        <!-- Top-Header -->
        <div class="full-layer-outer-header">
            <div class="container clearfix">
                <nav>
                    <ul class="primary-nav g-nav">
                        <li>
                            <a href="tel:+84398730223">
                                <i class="fas fa-phone u-c-brand u-s-m-r-9"></i>
                                Telephone: +84 398730223</a>
                        </li>
                        <li>
                            <a href="mailto:2051010108huy@ou.edu.vn">
                                <i class="fas fa-envelope u-c-brand u-s-m-r-9"></i>
                                E-mail: 2051010108huy@ou.edu.vn
                            </a>
                        </li>
                    </ul>
                </nav>
                <nav>
                    <ul class="secondary-nav g-nav">
                        <li>
                            <a>@if(Auth::check()) Tài khoản của tôi @else Đăng nhập/Đăng kí @endif
                                <i class="fas fa-chevron-down u-s-m-l-9"></i>
                            </a>
                            <ul class="g-dropdown" style="width:200px">
                                <li>
                                    <a href="{{ url('/cart') }}">
                                        <i class="fas fa-cog u-s-m-r-9"></i>
                                        Giỏ hàng</a>
                                </li>
                                <!-- <li>
                                    <a href="wishlist.html">
                                        <i class="far fa-heart u-s-m-r-9"></i>
                                        Danh sách yêu thích</a>
                                </li> -->
                                <li>
                                    <a href="{{ url('/checkout') }}">
                                        <i class="far fa-check-circle u-s-m-r-9"></i>
                                        Thanh toán</a>
                                </li>
                                @if(Auth::check())
                                <li>
                                    <a href="{{ url('/user/account') }}">
                                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                        Tài khoản của tôi</a>
                                </li>
                                <li>
                                    <a href="{{ url('/user/orders') }}">
                                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                        Đơn hàng của tôi</a>
                                </li>
                                <li>
                                    <a href="{{ url('/user/logout') }}">
                                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                        Đăng xuất</a>
                                </li>
                                @else
                                <li>
                                    <a href="{{ url('/user/login-register') }}">
                                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                        Khánh hàng đăng nhập</a>
                                </li>
                                <li>
                                    <a href="{{ url('/vendor/login-register') }}">
                                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                        Nhà cung cấp đăng nhập</a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        <li>
                            <a>Đồng
                                <i class="fas fa-chevron-down u-s-m-l-9"></i>
                            </a>
                            <ul class="g-dropdown" style="width:90px">
                                <li>
                                    <a href="#" class="u-c-brand">(₫) Đồng</a>
                                </li>
                                <li>
                                    <a href="#">(£) GBP</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a>VN
                                <i class="fas fa-chevron-down u-s-m-l-9"></i>
                            </a>
                            <ul class="g-dropdown" style="width:70px">
                                <li>
                                    <a href="#" class="u-c-brand">VN</a>
                                </li>
                                <li>
                                    <a href="#">ARB</a>
                                </li>
                            </ul>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Top-Header /- -->
        <!-- Mid-Header -->
        <div class="full-layer-mid-header">
            <div class="container">
                <div class="row clearfix align-items-center">
                    <div class="col-lg-3 col-md-9 col-sm-6">
                        <div class="brand-logo text-lg-center">
                            <a href="{{url('/')}}">
                                <!-- chỗ đổi logo nha -->
                                <img src="{{ asset('front/images/main-logo/logofpt.png') }}" alt="Stack Developers" class="app-brand-logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 u-d-none-lg">
                        <form class="form-searchbox" action="{{ url('search-products') }}" method="get">
                            <label class="sr-only" for="search-landscape">Tìm kiếm</label>
                            <input name="search" id="search-landscape" type="text" class="text-field" placeholder="Search everything" @if(isset($_REQUEST['search']) && !empty($_REQUEST['search'])) value="{{$_REQUEST['search']}}" @endif>
                            <div class="select-box-position">
                                <div class="select-box-wrapper select-hide">
                                    <label class="sr-only" for="select-category">Chọn danh mục để tìm kiếm</label>
                                    <select class="select-box" id="select-category" name="section_id">
                                        <option selected="selected" value="">
                                            Tất cả
                                        </option>
                                        @foreach($sections as $section)
                                        <option @if(isset($_REQUEST['section_id']) && !empty($_REQUEST['section_id']) && $_REQUEST['section_id']==$section['id']) selected="" @endif value="{{ $section['id'] }}" >{{ $section['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button id="btn-search" type="submit" class="button button-primary fas fa-search"></button>
                        </form>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <nav>
                            <ul class="mid-nav g-nav">
                                <li class="u-d-none-lg">
                                    <a href="{{url('/')}}">
                                        <i class="ion ion-md-home u-c-brand"></i>
                                    </a>
                                </li>
                                <!-- <li class="u-d-none-lg">
                                    <a href="wishlist.html">
                                        <i class="far fa-heart"></i>
                                    </a>
                                </li> -->
                                <li>
                                    <a id="mini-cart-trigger">
                                        <i class="ion ion-md-basket"></i>
                                        <span class="item-counter totalCartItems">{{ $totalCartItems }}</span>
                                        <!-- <span class="item-price">$220.00</span> -->
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mid-Header /- -->
        <!-- Responsive-Buttons -->
        <div class="fixed-responsive-container">
            <div class="fixed-responsive-wrapper">
                <button type="button" class="button fas fa-search" id="responsive-search"></button>
            </div>
            <!-- <div class="fixed-responsive-wrapper">
                <a href="wishlist.html">
                    <i class="far fa-heart"></i>
                    <span class="fixed-item-counter">4</span>
                </a>
            </div> -->
        </div>
        <!-- Responsive-Buttons /- -->
        <!-- Mini Cart -->
        <div id="appendHeaderCartItems">
        @include('front.layout.header_cart_items')
        </div>
        <!-- Mini Cart /- -->
        <!-- Bottom-Header -->
        <div class="full-layer-bottom-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <div class="v-menu v-close">
                            <span class="v-title">
                                <i class="ion ion-md-menu"></i>
                                tất cả sản phẩm
                                <i class="fas fa-angle-down"></i>
                            </span>
                            <nav>
                                <div class="v-wrapper">
                                    <ul class="v-list animated fadeIn">
                                        @foreach($sections as $section)
                                        @if(count($section['categories'])>0)
                                        <li class="js-backdrop">
                                            <a href="javascript:;">
                                                <i class="ion-ios-add-circle"></i>
                                                {{ $section['name'] }}
                                                <i class="ion ion-ios-arrow-forward"></i>
                                            </a>
                                            <button class="v-button ion ion-md-add"></button>
                                            <div class="v-drop-right" style="width: 700px;">
                                                <div class="row">
                                                    @foreach($section['categories'] as $category)
                                                    <div class="col-lg-4">
                                                        <ul class="v-level-2">
                                                            <li>
                                                                <a href="{{url($category['url'])}}">{{ $category['category_name'] }}</a>
                                                                <ul>
                                                                @foreach($category['subcategories'] as $subcategory)
                                                                    <li>
                                                                        <a href="{{url($subcategory['url'])}}">{{$subcategory['category_name']}}</a>
                                                                    </li>
                                                                    @endforeach
                                                                    
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                   @endforeach
                                                </div>
                                            </div>
                                        </li>
                                        @endif
                                        @endforeach
                                     
                                        
                                        <!-- <li>
                                            <a class="v-more">
                                                <i class="ion ion-md-add"></i>
                                                <span>View More</span>
                                            </a>
                                        </li> -->
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <ul class="bottom-nav g-nav u-d-none-lg">
                            <li>
                                <a href="{{url('/Apple')}}">Điện thoại
                                    <span class="superscript-label-new">NEW</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/Lenovo')}}">Laptop
                                    <span class="superscript-label-hot">HOT</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/Coolpad')}}">Máy tính bảng
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/Havit')}}">Tai nghe
                                    <span class="superscript-label-discount">-30%</span>
                                </a>
                            </li>
                            <li class="mega-position">
                                <a>Thêm
                                    <i class="fas fa-chevron-down u-s-m-l-9"></i>
                                </a>
                                <div class="mega-menu mega-3-colm">
                                    <ul>
                                        <li class="menu-title">LIÊN HỆ</li>
                                        <li>
                                            <a href="#" class="u-c-brand">Về chúng tôi</a>
                                        </li>
                                        <li>
                                            <a href="https://www.facebook.com/dongniengshop">Fanpage</a>
                                        </li>
                                        <li>
                                            <a href="https://vi.wikipedia.org/wiki/FAQ">FAQ</a>
                                        </li>
                                    </ul>
                                    <ul>
                                        <li class="menu-title">THƯƠNG HIỆU</li>
                                        <li>
                                            <a href="{{url('Apple')}}">Apple</a>
                                        </li>
                                        <li>
                                            <a href="{{url('Samsung')}}">Samsung</a>
                                        </li>
                                        <li>
                                            <a href="{{url('Oppo')}}">Oppo</a>
                                        </li>
                                    </ul>
                                    <ul>
                                        <li class="menu-title">TÀI KHOẢN</li>
                                        <li>
                                            <a href="{{ url('/user/account') }}">Tài khoản của tôi</a>
                                        </li>
                                        <!-- <li>
                                            <a href="shop-v1-root-category.html">My Profile</a>
                                        </li> -->
                                        <li>
                                            <a href="{{ url('/user/orders') }}">Đơn hàng của tôi</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bottom-Header /- -->
    </header>
    <!-- Header /- -->