<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect()->to('/login');
});

Auth::routes();
Route::match(['get', 'post'], 'password/reset', 'Admin\SettingController@forgetPassword');
Route::get('password/resets/{token}', 'Admin\SettingController@verifyToken');
Route::post('confirm-password', 'Admin\SettingController@confirmNewPassword');


Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->namespace('Admin')->group(function () {
    // profile route
    Route::match(['get', 'post'], 'profile', 'UserController@profile');
    // buyers route
    Route::get('buyers', 'UserController@buyers');
    Route::match(['get', 'post'], 'create-new-buyer', 'UserController@createNewBuyer');
    Route::match(['get', 'post'], 'buyers/{id}', 'UserController@editBuyer');
    Route::post('delete-buyer/{id}', 'UserController@deleteBuyer');
    // sellers route
    Route::get('sellers', 'UserController@sellers');
    Route::match(['get', 'post'], 'create-new-seller', 'UserController@createNewSeller');
    Route::match(['get', 'post'], 'sellers/{id}', 'UserController@editSeller');
    Route::post('delete-seller/{id}', 'UserController@deleteSeller');
    // countries routes
    Route::get('countries', 'CountryController@index');
    Route::post('country/{id}', 'CountryController@edit');
    // sizes routes
    Route::get('sizes', 'SizeController@index');
    Route::post('create-new-size', 'SizeController@create');
    Route::post('size/{id}', 'SizeController@edit');
    Route::post('delete-size/{id}', 'SizeController@delete');
    // units routes
    Route::get('units', 'UnitController@index');
    Route::post('create-new-unit', 'UnitController@create');
    Route::post('unit/{id}', 'UnitController@edit');
    Route::post('delete-unit/{id}', 'UnitController@delete');
    // packaging sizes routes
    Route::get('packaging-sizes', 'PackagingSizeController@index');
    Route::post('create-new-packaging-sizes', 'PackagingSizeController@create');
    Route::post('packaging-sizes/{id}', 'PackagingSizeController@edit');
    Route::post('delete-packaging-sizes/{id}', 'PackagingSizeController@delete');
    // packaging materials routes
    Route::get('packaging-materials', 'PackagingMaterialController@index');
    Route::post('create-new-packaging-materials', 'PackagingMaterialController@create');
    Route::post('packaging-materials/{id}', 'PackagingMaterialController@edit');
    Route::post('delete-packaging-materials/{id}', 'PackagingMaterialController@delete');
    // location routes
    Route::get('locations', 'LocationController@index');
    Route::post('create-new-location', 'LocationController@create');
    Route::post('location/{id}', 'LocationController@edit');
    Route::post('delete-location/{id}', 'LocationController@delete');
    // variety routes
    Route::get('varieties', 'VarietyController@index');
    Route::match(['get', 'post'], 'create-new-variety', 'VarietyController@create');
    Route::match(['get', 'post'], 'variety/{id}', 'VarietyController@edit');
    Route::post('delete-variety/{id}', 'VarietyController@delete');
    // product routes
    Route::get('products', 'ProductController@index');
    Route::match(['get', 'post'], 'create-new-product', 'ProductController@create');
    Route::match(['get', 'post'], 'product/{id}', 'ProductController@edit');
    Route::get('view-product/{id}', 'ProductController@showProductDetails');
    Route::get('products-selling-today', 'ProductController@showProductsSellingToday');
    Route::get('expired-products', 'ProductController@expiredProducts');
    Route::post('delete-product/{id}', 'ProductController@delete');
    // settings routes
    Route::match(['get', 'post'], 'company-settings', 'SettingController@index');
    // Identity Verification routes
    Route::get('verifications', 'VerificationController@index');
    Route::match(['get', 'post'], 'edit-verification/{id}', 'VerificationController@edit');
    Route::match(['get', 'post'], 'create-new-verification', 'VerificationController@create');
    Route::get('activity-logs', 'ActivityLogController@index');
    // Orders route
    Route::get('orders', 'OrderController@index');
});

