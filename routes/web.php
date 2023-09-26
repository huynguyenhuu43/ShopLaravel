<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){

    //admin login route without admin group
    Route::match(['get','post'] ,'login','AdminController@login');
    Route::group(['middleware'=>['admin']],function(){
        //admin dashboard route without admin group
        Route::get('dashboard','AdminController@dashboard');

        //Update admin password
        Route::match(['get','post'],'update-admin-password','AdminController@updateAdminPassword');
        //check admin password
        Route::post('check-admin-password','AdminController@checkAdminPassword');
        //update admin details
        Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');
        //update vendor details
        Route::match(['get','post'],'update-vendor-details/{slug}','AdminController@updateVendorDetails');
        //view admins/subadmins/vendors
        Route::get('admins/{type?}','AdminController@admins');
        //view vendor details
        Route::get('view-vendor-details/{id}','AdminController@viewVendorDetails');
        //update admin status
        Route::post('update-admin-status','AdminController@updateAdminStatus');
        //admin logout
        Route::get('logout','AdminController@logout');
        //sections
        Route::get('sections','SectionController@sections');
        Route::post('update-section-status','SectionController@updateSectionStatus');
        Route::get('delete-section/{id}','SectionController@deleteSection');
        Route::match(['get','post'],'add-edit-section/{id?}','SectionController@addEditSection');

        //brands
        Route::get('brands','BrandController@brands');
        Route::post('update-brand-status','BrandController@updateBrandStatus');
        Route::get('delete-brand/{id}','BrandController@deleteBrand');
        Route::match(['get','post'],'add-edit-brand/{id?}','BrandController@addEditBrand');
        //category
        Route::get('categories','CategoryController@categories');
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');

        Route::get('append-categories-level', 'CategoryController@appendCategoryLevel');
        Route::get('delete-category/{id}','CategoryController@deleteCategory');
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');

        //products
        Route::get('products','ProductsController@products');
        Route::post('update-product-status','ProductsController@updateProductStatus');
        Route::get('delete-product/{id}','ProductsController@deleteProduct');
        Route::match(['get','post'],'add-edit-product/{id?}','ProductsController@addEditProduct');

        Route::get('delete-product-image/{id}','ProductsController@deleteProductImage');
        Route::get('delete-product-video/{id}','ProductsController@deleteProductVideo');

        Route::match(['get','post'],'add-edit-attributes/{id}','ProductsController@addAttributes');
        Route::post('update-attribute-status','ProductsController@updateAttributeStatus');
        Route::get('delete-attribute/{id}','ProductsController@deleteAttribute');

        Route::match(['get','post'],'edit-attributes/{id}','ProductsController@editAttributes');

        //filter
        Route::get('filters','FilterController@filters');
        Route::get('filters-values','FilterController@filtersValues');
        Route::post('update-filter-status','FilterController@updateFilterStatus');
        Route::post('update-filter-value-status','FilterController@updateFilterValueStatus');
        Route::match(['get','post'],'add-edit-filter/{id?}','FilterController@addEditFilter');
        Route::match(['get','post'],'add-edit-filter-value/{id?}','FilterController@addEditFilterValue');
        Route::post('category-filters','FilterController@categoryFilters');
        
        // Images
        Route::match(['get','post'],'add-images/{id}','ProductsController@addImages');
        Route::post('update-image-status','ProductsController@updateImageStatus');
        Route::get('delete-image/{id}','ProductsController@deleteImage');

        //banner
        Route::get('banners','BannersController@banners');
        Route::post('update-banner-status','BannersController@updateBannerStatus');
        Route::get('delete-banner/{id?}','BannersController@deleteBanner');
        Route::match(['get','post'],'add-edit-banner/{id?}','BannersController@addEditBanner');

        //coupons
        // Coupons
        Route::get('coupons','CouponsController@coupons');
        Route::post('update-coupon-status','CouponsController@updateCouponStatus');
        Route::get('delete-coupon/{id?}','CouponsController@deleteCoupon');
        Route::match(['get','post'],'add-edit-coupon/{id?}','CouponsController@addEditCoupon');

        // Users
        Route::get('users','UserController@users');
        Route::post('update-user-status','UserController@updateUserStatus');

        // Orders
        Route::get('orders','OrderController@orders');
        Route::get('orders/{id}','OrderController@orderDetails');
        Route::post('update-order-status','OrderController@updateOrderStatus');
        Route::post('update-order-item-status','OrderController@updateOrderItemStatus');

        // Order Invoices
        Route::get('orders/invoice/{id}','OrderController@viewOrderInvoice');
        // Print PDF Invoice
        Route::get('orders/invoice/pdf/{id}','OrderController@printPDFInvoice');

    });
});

Route::namespace('App\Http\Controllers\Front')->group(function(){
    Route::get('/','IndexController@index');

    //listing
    $catUrls = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
    //dd($catUrls);
    foreach ($catUrls as $key =>$url){
        Route::match(['get','post'],'/'.$url,'ProductsController@listing');
    }

    // Vendor Products
    Route::get('/products/{vendorid}','ProductsController@vendorListing');

    // Product Detail Page
    Route::get('product/{id}','ProductsController@detail');

    // Get Product Attribute Price
    Route::post('get-product-price','ProductsController@getProductPrice');

    // Vendor Login/Register
    Route::get('vendor/login-register','VendorController@loginRegister');
    // Vendor Register
    Route::post('vendor/register','VendorController@vendorRegister');
    // Add to Cart Route
    Route::post('cart/add','ProductsController@cartAdd');
    // Cart Route
    Route::get('/cart','ProductsController@cart');
    // Update Cart Item Quantity
    Route::post('cart/update','ProductsController@cartUpdate');
    // Delete Cart Item
    Route::post('cart/delete','ProductsController@cartDelete');
    // User Login/Register
    Route::get('user/login-register','UserController@loginRegister');
    // User Register
    Route::post('user/register','UserController@userRegister');
    // Search Products
    Route::get('search-products','ProductsController@listing');
    //infor
    Route::get('infor/aboutus','InfoController@aboutus');
    
    // Users Account 
    Route::match(['GET','POST'],'user/account','UserController@userAccount');
    // User Update Password
    Route::post('user/update-password','UserController@userUpdatePassword');
    // Apply Coupon
    Route::post('/apply-coupon','ProductsController@applyCoupon');
    // Checkout
    Route::match(['GET','POST'],'/checkout','ProductsController@checkout');
    //address
    Route::match(['get','post'], '/get-delivery-address','AddressController@getDeliveryAddress');
    //save address
    Route::post('save-delivery-address','AddressController@saveDeliveryAddress');
    //remove address
    Route::post('remove-delivery-address','AddressController@removeDeliveryAddress');
    //thank
    Route::get('/thanks','ProductsController@thanks');
    // Users Orders
    Route::get('user/orders/{id?}','OrderController@orders');
    // Paypal
    Route::get('paypal','PaypalController@paypal');
    Route::post('pay','PaypalController@pay')->name('payment');
    Route::get('success','PaypalController@success');
    Route::get('error','PaypalController@error');
    // User Login
    Route::post('user/login','UserController@userLogin');
    // Logout User
    Route::get('user/logout','UserController@userLogout');
});


