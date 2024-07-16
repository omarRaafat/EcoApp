<?php

use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\ShippingStatusController;
use App\Http\Controllers\Vendor\ShippingTypeSettingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\OrderController;
use App\Http\Controllers\Vendor\ProductCountryPricesController;
use App\Http\Controllers\Vendor\OrderReportController;
use App\Http\Controllers\Vendor\AgreementController;
use App\Http\Controllers\Vendor\ServiceController;
use App\Http\Controllers\Vendor\ServiceOrderController;
use App\Http\Controllers\Vendor\ServiceReviewController;
use App\Http\Controllers\Vendor\TypeOfEmployeeController;
use App\Http\Controllers\Vendor\WarehouseController;

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
Route::redirect('/', '/vendor/login');
Auth::routes();
Route::get('password/send-code', 'Auth\ForgotPasswordController@showResetPasswordForm');
Route::post('password/confirm-phone', 'Auth\ForgotPasswordController@confirmPhone')->name('password.confirm-phone');

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);



Route::middleware(['vendor.auth', 'vendor.agreement-requested'])->group(function () {

    Route::get('/home', [App\Http\Controllers\Vendor\IndexController::class, 'index'])->name('index');
    Route::get('/chart-api', [App\Http\Controllers\Vendor\IndexController::class, 'chartApi'])->name('chartApi');

    Route::get('profile', 'ProfileController@show')->name('profile');
    Route::get('edit-profile', 'ProfileController@edit')->name('edit-profile');
    Route::post('update-vendor', 'ProfileController@updateVendor')->name('update-vendor');;
    Route::post('update-profile', 'ProfileController@update')->name('update-profile');;
    Route::post('change-password', 'ProfileController@changePassword')->name('change-password');;

    //resources warehouse
    Route::resource('warehouses', 'WarehouseController'); //->middleware('vendor_permission:product');
    Route::get("warehouses/export/excel", [WarehouseController::class, "excel"])->name('warehouses.export');

    //resources
    Route::middleware(['check.service:selling_products'])->group(function () {
        Route::resource('products', 'ProductController')->middleware('vendor_permission:product');
        Route::post('/products/stock-update/{product}', [ProductController::class, 'updateStock'])->name('products.update-stock');
        Route::get('/products/stock-delete/{id}', [ProductController::class, 'deleteStock'])->name('products.delete-stock');
        Route::get("products/export/excel", [ProductController::class, "excel"])->name('products.export');
    // Route::get('product/{id}/countries_prices', 'ProductController@invoice')->name('vendor_product_country_prcies');
    /* Manage Countries Prices */
        Route::get('products/{id}/prices', [ProductCountryPricesController::class, 'index'])->name('products.prices.list');
        Route::post('products/{id}/prices', [ProductCountryPricesController::class, 'store'])->name('products.prices.store');
        Route::put('products/{id}/prices', [ProductCountryPricesController::class, 'update'])->name('products.prices.update');
        Route::get('products/{id}/prices/create', [ProductCountryPricesController::class, 'create'])->name('products.prices.create');
        Route::get('products/prices/edit/{id}', [ProductCountryPricesController::class, 'edit'])->name('products.prices.edit');
        Route::delete('products/prices/{id}', [ProductCountryPricesController::class, 'destroy'])->name('products.prices.delete');
    });

    //services
    Route::middleware(['check.service:agricultural_services'])->group(function () {
        Route::resource('services', 'ServiceController')->middleware('vendor_permission:services');
        Route::get('/categories/{category}/fields', [ServiceController::class, 'getFields'])->name('services.get_fields');
        Route::get("services/export/excel", [ServiceController::class, "excel"])->name('services.export');
    });

    Route::get('tracking_aramex/{track_id}', [OrderController::class, 'trackingAramex'])->name('order.trackingAramex');
    Route::resource('orders', 'OrderController')->middleware('vendor_permission:order');
    Route::get("orders/export/excel", [OrderController::class, "excel"])->name('orders.export');
    Route::get("orders-download-invoices", [OrderController::class, "downloadInvoices"])->name('orders.download-invoices');


    Route::get("orders/resend_receive_code/{id}", [OrderController::class, "resendReceiveCode"])->name('orders.resend_receive_code')->middleware('vendor_permission:order');
    Route::post('orders/note/{id}', [OrderController::class,'saveNote'])->name('order.note')->middleware('vendor_permission:order');
    Route::resource('orders', 'OrderController')->middleware('vendor_permission:order');
    Route::get('orders/invoice/{order:id}', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('orders/invoice-pdf/{order:id}', [OrderController::class, 'invoicePdf'])->name('orders.pdf-invoice');
    Route::get('orders/PrintLabel/{tracking}', [OrderController::class, 'PrintLabel'])->name('orders.PrintLabel');
    Route::resource('users', 'VendorUserController')->middleware('vendor_permission:user');
    Route::resource('roles', 'RoleController')->middleware('vendor_permission:role');
    Route::resource('certificates', 'CertificateController')->middleware('vendor_permission:certificate');

    Route::get('product-reviews', 'ProductReviewController@index')->name('product-reviews')->middleware('vendor_permission:review');
    Route::post('orders/multi-delete', 'OrderController@multiDelete')->name('orders.multi-delete');
    Route::get('get-category-by-parent-id', 'ProductController@getSubCategories')->name('get_sub_categories');
    Route::get('products-for-table', 'ProductController@productForTable')->name('products-for-table');
    Route::post('upload-image', 'ImageController@upload_product_images')->name('upload_product_images')->middleware('vendor_permission:product');


    // Service Orders
    Route::resource('service-orders', ServiceOrderController::class)->middleware('vendor_permission:order_services');
    Route::get("service-orders/export/excel", [ServiceOrderController::class, "excel"])->name('service_orders.export');
    Route::get("service-orders-download-invoices", [ServiceOrderController::class, "downloadInvoices"])->name('service_orders.download-invoices');
    Route::get("service-orders/resend_receive_code/{id}", [ServiceOrderController::class, "resendReceiveCode"])->name('service_orders.resend_receive_code')->middleware('vendor_permission:order');
    Route::post('service-orders/note/{id}', [ServiceOrderController::class,'saveNote'])->name('service_order.note')->middleware('vendor_permission:order');
    Route::get('service-orders/invoice/{order:id}', [ServiceOrderController::class, 'invoice'])->name('service_orders.invoice');
    Route::get('service-orders/invoice-pdf/{order:id}', [ServiceOrderController::class, 'invoicePdf'])->name('service_orders.pdf-invoice');
    Route::get('service-reviews', [ServiceReviewController::class,'index'])->name('service-reviews')->middleware('vendor_permission:review');
    Route::post('service-orders/multi-delete', [ServiceOrderController::class, 'multiDelete'])->name('service_orders.multi-delete');
    // vendor_user make assign order request
    Route::post('service-orders/assign-service-request',[ServiceOrderController::class,'assignServiceRequest'])->name('service_orders.assign-service-request');
    // wherehouse requests
    Route::middleware(['vendor_permission:warehouse'])->group(function () {
        Route::get('warehouse-request/create', 'VendorWarehouseRequestController@create')->name('warhouse_request.create');
        Route::post('warehouse-request/store', 'VendorWarehouseRequestController@store')->name('warhouse_request.store');
        Route::get('warehouse-request', 'VendorWarehouseRequestController@index')->name('warhouse_request.index');
        Route::get('warehouse-request/product/{id}', 'VendorWarehouseRequestController@showProducts')->name('warhouse_request.show-products');
        Route::get('warehouse-request/{id}', 'VendorWarehouseRequestController@show')->name('warhouse_request.show');
    });

    Route::get('wallet', 'WalletController@show')->name('wallet')->middleware('is_vendor_owner');
    // type of employee route
    Route::resource('type-of-employees',TypeOfEmployeeController::class)->middleware('vendor_permission:type_of_employees');
    Route::prefix('reports')
        ->middleware(['vendor_permission:reports'])
        ->controller(OrderReportController::class)
        ->group(function () {
            Route::get('orders-report', 'index')->name('reports.orders-report.index');
            Route::get('orders-report/print', 'print')->name('reports.orders-report.print');
            Route::get('orders-report/excel', 'excel')->name('reports.orders-report.excel');
        });

    Route::prefix("agreements")
        ->controller(AgreementController::class)
        ->as('agreements.')
        ->group(function () {
            Route::put('approve', 'approve')->name("approve");
            Route::get('/', 'index')->name("index");
        });


//    Route::prefix("settings")
//        ->controller(ShippingTypeSettingController::class)
//        ->as('shipping.')
//        ->group(function () {
//            Route::patch('update', 'update')->name("update");
//            Route::get('/edit', 'edit')->name("edit");
//        });

    Route::post('change-shipping-status', [ShippingStatusController::class, 'changeShippingStatus'])->name('change_shipping_status');
    Route::post('check-otp-to-recieve', [ShippingStatusController::class, 'checkOtp'])->name('order.check_otp');

    Route::post('service-change-shipping-status', [ShippingStatusController::class, 'serviceChangeShippingStatus'])->name('service_change_shipping_status');
    Route::post('service-check-otp-to-recieve', [ShippingStatusController::class, 'serviceCheckOtp'])->name('service_order.check_otp');
});



// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
