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

Route::get('login', 'AuthController@login');
Route::get('logout', 'AuthController@logout')->name('logout');
Route::post('login', 'AuthController@login')->name('login');
Route::middleware('CheckAuth')->group(function(){
    Route::get('/', 'DashboardController@Index')->name('index');

    Route::prefix('reseller')->group(function(){
        Route::get('reseller-data', 'ResellerController@ResellerData')->name('reseller-data');
        Route::get('reseller/{uid}', 'ResellerController@Reseller');
        Route::get('reseller-delete/{uid}', 'ResellerController@ResellerDelete');

        // Customer
        Route::get('reseller-customer-detail/{uid}', 'ResellerController@ResellerCustomerDetail');
        Route::get('reseller-customer-delete/{uid}/{reseller_uid}', 'ResellerController@ResellerCustomerDelete');
        Route::post('reseller-addcustomer', 'ResellerController@ResellerAddCustomer')->name('reseller-addcustomer');
    });
    Route::prefix('supplier')->group(function(){
        Route::get('supplier-data', 'SupplierController@SupplierData')->name('supplier-data');
    });
    Route::prefix('products')->group(function(){
        Route::get('product-stock', 'ProductController@ProductStock')->name('product-stock');
        Route::get('product-setting', 'ProductController@ProductSetting')->name('product-setting');
        Route::get('product-type-delete/{id}', 'ProductController@ProductTypeDelete');
        Route::post('product-type-regist', 'ProductController@ProductTypeRegist');

        Route::post('product-merk-regist', 'ProductController@ProductMerkRegist');
        Route::get('product-merk-delete/{id}', 'ProductController@ProductMerkDelete');

        Route::post('product-stock-regist', 'ProductController@ProductStockRegist')->name('product-stock-regist');
        Route::get('product-stock-delete/{id}', 'ProductController@ProductStockDelete');
    });
    Route::prefix('financial')->group(function(){
        Route::get('bank-account-info', 'FinancialController@BankAccount')->name('bank-account-info');
        Route::get('bank-account-info/{id}', 'FinancialController@BankAccountDetail');
        Route::get('credit', 'FinancialController@Credit')->name('credit');
        Route::get('debit', 'FinancialController@Debit')->name('debit');
        Route::post('bank-account-top-up', 'FinancialController@BankAccountTopUp')->name('top-up');
    });
    Route::prefix('order')->group(function(){
        Route::get('orders', 'OrderController@orders')->name('orders');
        Route::get('order-detail/{id}', 'OrderController@orderDetail');
        Route::get('get-order-form', 'OrderController@ajaxGetOrderForm')->name('get-order-form');
        Route::post('get-customer-order-when-reseller-selected', 'OrderController@getCustomerWhenResellerSelected')->name('get-customer');
        Route::post('add-new-order', 'OrderController@addNewOrder')->name('new-order');
        Route::post('pay-order', 'OrderController@payOrder')->name('pay-order');
    });
});
