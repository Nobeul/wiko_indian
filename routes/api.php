<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['namespace' => 'Api'], function ()
{
    Route::match(['get', 'post'], 'login', 'LoginController@login');
    Route::match(['get', 'post'], 'register', 'LoginController@register');
    Route::match(['get', 'post'], 'get-otp', 'LoginController@generateOtp');
});

Route::group(['namespace' => 'Api', 'middleware' => ['auth:api']], function ()
{
    // Products routes
    Route::get('admin-listed-products', 'ProductController@index');
    Route::get('seller-products', 'ProductController@sellerProductList');
    Route::match(['get', 'post'], 'create-new-product', 'ProductController@create');
    Route::match(['get', 'post'], 'product/{id}', 'ProductController@edit');
    Route::match(['get', 'post'], 'delete-product/{id}', 'ProductController@delete');
    Route::match(['get', 'post'], 'product-filter-for-buyer', 'ProductController@filterForBuyer');
    // buyers routes
    Route::match(['get', 'post'], 'buyers', 'UserController@buyers');
    Route::match(['get', 'post'], 'create-new-buyer', 'UserController@createNewBuyer');
    Route::match(['get', 'post'], 'buyer/{id}', 'UserController@editBuyer');
    Route::match(['get', 'post'], 'delete-buyer/{id}', 'UserController@deleteBuyer');
    // sellers routes
    Route::match(['get', 'post'], 'sellers', 'UserController@sellers');
    Route::match(['get', 'post'], 'create-new-seller', 'UserController@createNewSeller');
    Route::match(['get', 'post'], 'seller/{id}', 'UserController@editSeller');
    Route::match(['get', 'post'], 'delete-seller/{id}', 'UserController@deleteSeller');
    // User verification routes
    Route::match(['get', 'post'], 'create-verification', 'VerificationController@create');
    Route::match(['get', 'post'], 'verification-types', 'VerificationController@verificationTypes');
    // Countries
    Route::match(['get', 'post'], 'countries', 'CountryController@index');
    // units routes
    Route::match(['get', 'post'], 'units', 'UnitController@index');
    // sizes routes
    Route::match(['get', 'post'], 'sizes', 'UnitController@getSizes');
    // Packaging sizes routes
    Route::match(['get', 'post'], 'packaging-sizes', 'UnitController@getPackagingSizes');
    // Packaging materials routes
    Route::match(['get', 'post'], 'packaging-materials', 'UnitController@getPackagingMaterials');
    // Locations routes
    Route::match(['get', 'post'], 'locations', 'UnitController@getLocations');
    // Varieties routes
    Route::match(['get', 'post'], 'varieties', 'UnitController@getVarieties');
    // Activity log routes
    Route::match(['get', 'post'], 'activity-logs', 'UnitController@getActivityLogs');
    // Orders route
    Route::match(['get', 'post'], 'create-order', 'OrderController@create');
    Route::match(['get', 'post'], 'orders', 'OrderController@index');
    Route::match(['get', 'post'], 'create-notification', 'OrderController@createNotification');
    Route::match(['get', 'post'], 'notification', 'OrderController@viewNotification');
    Route::match(['get', 'post'], 'notifications', 'OrderController@getNotifications');
    // Ratings route
    Route::match(['get', 'post'], 'create-product-rating', 'RatingController@createReviewForProduct');
    Route::match(['get', 'post'], 'create-user-rating', 'RatingController@createReviewForUser');
    Route::match(['get', 'post'], 'product-ratings', 'RatingController@getAllProductRatings');
    Route::match(['get', 'post'], 'user-ratings', 'RatingController@getAllUserRatings');
    // Logout
    Route::match(['get', 'post'], 'logout', 'LoginController@logout');
});

Route::group(['namespace' => 'Api'], function ()
{
    Route::match(['get', 'post'], 'channel-pop', 'ChannelController@index');
});
