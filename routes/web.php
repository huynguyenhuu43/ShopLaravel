<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
        //category
        Route::get('categories','CategoryController@categories');
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
    });
});

