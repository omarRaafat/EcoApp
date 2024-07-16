<?php

use App\Http\Controllers\Admin\ClientSMSController;
use App\Http\Controllers\Admin\DispensingOrderController;
use App\Http\Controllers\Admin\LineShippingPriceController;
use App\Http\Controllers\Admin\RuleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Vendor\ImageController;
use App\Http\Controllers\Admin\ProductClassController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SubAdminController;
use App\Http\Controllers\Admin\CustomerCashWithdrawRequestController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\VendorWarningsController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\VendorRateController;
use App\Http\Controllers\Admin\TransactionProcessRateController;
use App\Http\Controllers\Admin\OrderProcessRateController;
use App\Http\Controllers\Admin\ProductRateController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductQuantityController;
use App\Http\Controllers\Admin\AboutUsContentController;
use App\Http\Controllers\Admin\ClientMessageController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DomesticZoneController;
use App\Http\Controllers\Admin\DomesticZoneDeliveryFeesController;
use App\Http\Controllers\Admin\PageSeoController;
use App\Http\Controllers\Admin\InternationalTaxInvoiceController;
use App\Http\Controllers\Admin\PostHarvestServicesController;
use App\Http\Controllers\Admin\PostHarvestServicesDepartmentFieldController;
use App\Http\Controllers\Admin\PalmLengthController;
use App\Http\Controllers\Admin\PreharvestCategoryController;
use App\Http\Controllers\Admin\PreharvestStageController;
use App\Http\Controllers\Admin\TorodCompanyController;
use App\Http\Controllers\Admin\UsageAgreementContentController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\VendorUserController;
use App\Http\Controllers\Admin\VendorWalletController;
use App\Http\Controllers\Admin\PrivacyPolicyContentController;
use App\Http\Controllers\Admin\ProductCountryPricesController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ServiceCartController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceRateController;
use App\Http\Controllers\Admin\ServiceTaxInvoiceController;
use App\Http\Controllers\Admin\ServiceTransactionController;
use App\Http\Controllers\Admin\VendorWarehouseRequestController;
use App\Http\Controllers\Admin\ShippingMethodController;
use App\Http\Controllers\Admin\TaxInvoiceController;
use App\Http\Controllers\Admin\VendorReportController;
use App\Http\Controllers\Admin\VendorAgreementController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Vendor\ServiceImageController;

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

//Auth routes for admin
Route::get('login', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('loginPost', [LoginController::class, 'login'])->middleware('guest')->name('loginPost');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('forget', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('forget');
Route::post('forget', [ForgotPasswordController::class, 'sendResetLinkEmail']);

Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password_reset_get');
Route::post('reset-password', [ResetPasswordController::class, 'submitResetPasswordForm'])->name('password_reset_post');

Route::middleware(['admin.auth', 'admin.can'])->group(function () {
    /* Home dashboard routes */
    Route::get('home', [AdminController::class, 'index'])->name('home');
    Route::get('chart-api', [AdminController::class, 'chartApi'])->name('chartApi');
    Route::get('/', [AdminController::class, 'index']);




    /* Notifications routes */
    //Route::get('/send-notification',[AdminController::class,'notification'])->name('notification');
    Route::patch('/notifications/fcm-token', [AdminController::class, 'updateToken'])->name('notifications.fcmToken');
    Route::post('/notifications/mark-as-read', [AdminController::class, 'markNotification'])->name('notifications.mark-as-read');

    /* Vendor routes */
    // Breadcrumb done
    Route::get('vendors', [VendorController::class, 'index'])->name('vendors.index');
    Route::get('vendors/show/{vendor:id}', [VendorController::class, 'show'])->name('vendors.show');
    Route::get('vendors/edit/{vendor:id}', [VendorController::class, 'edit'])->name('vendors.edit');
    Route::post('vendors/update/{vendor:id}', [VendorController::class, 'update'])->name('vendors.update');
    Route::post('vendors/approve/{vendor:id}', [VendorController::class, 'approve'])->name('vendors.approve');
    Route::post('vendors/activation/{vendor:id}', [VendorController::class, 'changeStatus'])->name('vendors.change-status');
    Route::post('vendors/accept-set-ratio', [VendorController::class, 'accept_set_ratio'])->name('vendors.accept-set-ratio'); //ajax
    //Route::get('vendor/delete/{vendor:id}', [VendorController::class,'destroy'])->name('vendorsDelete');

    /* Customers routes */
    // Breadcrumb done
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('customers/export', [CustomerController::class, 'exportCustomers'])->name('customers.export');

    Route::get('customers/show/{user:id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::post('customers/priority/{user:id}', [CustomerController::class, 'changePriority'])->name('customers.change-priority');
    Route::post('customers/block/{user:id}', [CustomerController::class, 'block'])->name('customers.block');
    Route::get('customers/edit/{user:id}', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::post('customers/update/{user:id}', [CustomerController::class, 'update'])->name('customers.update');

    /* Vendor Warnings routes */
    // Breadcrumb done
    Route::get('vendors/warnings/{vendor:id}', [VendorWarningsController::class, 'index'])->name('vendors.warnings.index');
    Route::post('vendors/warnings/store/', [VendorWarningsController::class, 'store'])->name('vendors.warnings.store');

    /* transactions routes */
    // Breadcrumb done
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/canceled_orders', [TransactionController::class, 'canceled_orders'])->name('transactions.canceled_orders');
    Route::get('transactions/shipping_failed_orders', [TransactionController::class, 'shippingFailedOrders'])->name('transactions.shipping_failed_orders');
    Route::post('transactions/shipping_failed_orders/resend/{id}', [TransactionController::class, 'shippingFailedOrdersResend'])->name('transactions.shipping_failed_orders.resend');
    Route::get('transactions/sub_orders', [TransactionController::class, 'sub_orders'])->name('transactions.sub_orders');
    Route::post('transactions/sub_orders/change-warehouse/{order_vendor_warehouse_id}', [TransactionController::class, 'changeWarehouse'])->name('transactions.sub_orders.change_warehouse');
    Route::get('transactions/refund_status_completed/{order}', [TransactionController::class, 'refund_status_completed'])->name('transactions.refund_status_completed');
    Route::get('transactions/show/{transaction:id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('transactions/invoice/{transaction:id}', [TransactionController::class, 'invoice'])->name('transactions.invoice');
    Route::get('transactions/invoice-pdf/{transaction:id}', [TransactionController::class, 'invoicePdf'])->name('transactions.pdf-invoice');
    Route::get('transactions/manage/{transaction:id}', [TransactionController::class, 'manage'])->name('transactions.manage');
    Route::post('transactions/update/{transaction:id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::put('transactions/send-to-bezz/{transaction:id}', [TransactionController::class, 'sendToBezz'])->name('transactions.send-to-bezz');
    Route::get('transactions-order/{order}/get-status', [TransactionController::class, 'getOrderStatus'])->name('get_order_status');
    Route::put('transactions-order/{order}/update-status', [TransactionController::class, 'updateOrderStatus'])->name('update_order_status');
    Route::get('transactions/PrintLabel/{tracking}', [TransactionController::class, 'PrintLabel'])->name('transactions.PrintLabel');

    Route::get("transactions/export/excel", [TransactionController::class, "excel"])->name('transactions.export');
    Route::get("transactions/canceled_export/excel", [TransactionController::class, "canceled_export"])->name('transactions.canceled_export');
    Route::get("transactions/sub_orders_export/excel", [TransactionController::class, "sub_orders_export"])->name('transactions.sub_orders_export');
    Route::get("transactions/sub_orders/resend_receive_code/{id}", [TransactionController::class, "resendReceiveCode"])->name('transactions.sub_orders.resend_receive_code');

    Route::post('transactions/cancelOrder/{order:id}', [TransactionController::class, 'cancelOrder'])->name('transactions.cancelOrder');

    Route::post('transactions/refundOrder/{order:id}', [TransactionController::class, 'refundOrder'])->name('transactions.refundOrder');


    /* Service transactions routes */
    // Breadcrumb done
    Route::get('service-transactions', [ServiceTransactionController::class, 'index'])->name('service_transactions.index');
    Route::get('service-transactions/canceled_orders', [ServiceTransactionController::class, 'canceled_orders'])->name('service_transactions.canceled_orders');
    Route::get('service-transactions/sub_orders', [ServiceTransactionController::class, 'sub_orders'])->name('service_transactions.sub_orders');
    Route::get('service-transactions/show/{transaction:id}', [ServiceTransactionController::class, 'show'])->name('service_transactions.show');
    Route::get('service-transactions/invoice/{transaction:id}', [ServiceTransactionController::class, 'invoice'])->name('service_transactions.invoice');
    Route::get('service-transactions/invoice-pdf/{transaction:id}', [ServiceTransactionController::class, 'invoicePdf'])->name('service_transactions.pdf-invoice');
    Route::get('service-transactions/manage/{transaction:id}', [ServiceTransactionController::class, 'manage'])->name('service_transactions.manage');
    Route::post('service-transactions/update/{transaction:id}', [ServiceTransactionController::class, 'update'])->name('service_transactions.update');
    Route::get('service-transactions-order/{order}/get-status', [ServiceTransactionController::class, 'getOrderStatus'])->name('get_service_order_status');
    Route::put('service-transactions-order/{order}/update-status', [ServiceTransactionController::class, 'updateOrderStatus'])->name('update_service_order_status');

    Route::get("service-transactions/export/excel", [ServiceTransactionController::class, "excel"])->name('service_transactions.export');
    Route::get("service-transactions/canceled_export/excel", [ServiceTransactionController::class, "canceled_export"])->name('service_transactions.canceled_export');
    Route::get("service-transactions/sub_orders_export/excel", [ServiceTransactionController::class, "sub_orders_export"])->name('service_transactions.sub_orders_export');
    Route::get("service-transactions/sub_orders/resend_receive_code/{id}", [ServiceTransactionController::class, "resendReceiveCode"])->name('service_transactions.sub_orders.resend_receive_code');

    Route::post('service-transactions/cancelOrder/{order:id}', [ServiceTransactionController::class, 'cancelOrder'])->name('service_transactions.cancelOrder');


    /* carts routes */
    // Breadcrumb done
    Route::get('carts', [CartController::class, 'index'])->name('carts.index');
    Route::get('carts/show/{cart:id}', [CartController::class, 'show'])->name('carts.show');
    Route::get('carts/delete/{cart:id}', [CartController::class, 'destroy'])->name('carts.delete');

    Route::get('service-carts', [ServiceCartController::class, 'index'])->name('service_carts.index');
    Route::get('service-carts/show/{cart:id}', [ServiceCartController::class, 'show'])->name('service_carts.show');
    Route::get('service-carts/delete/{cart:id}', [ServiceCartController::class, 'destroy'])->name('service_carts.delete');

    /* Manage Customers Wallets */
    // Breadcrumb done
    Route::get('wallets/{id}/manage-wallet-balance', [WalletController::class, 'manageWalleBalance'])->name('wallets.manageWalleBalance');
    Route::post('wallets/{id}/manage-wallet-balance', [WalletController::class, 'increaseAndDecreaseAmount'])->name('wallets.increaseAndDecreaseAmount');
    Route::resource('wallets', WalletController::class);

    /* Manage Categories */
    Route::group([
        "prefix" => "categories",
        "as" => "categories."
    ], function () {
        Route::get("", [CategoryController::class, "index"])->name("index");
        Route::get("create", [CategoryController::class, "create"])->name("create");
        Route::get("{parent_id}/create-sub-category", [CategoryController::class, "createSubCategory"])->name("createSubCategory");
        Route::get("{parent_id}/create-sub-child-category", [CategoryController::class, "createSubChildCategory"])->name("createSubChildCategory");
        Route::post("", [CategoryController::class, "store"])->name("store");
        Route::post("updateCategoryOrder", [CategoryController::class, "updateCategoryOrder"])->name("updateCategoryOrder");
        Route::get("show/{id}", [CategoryController::class, "show"])->name("show");
        Route::get("show-sub-category/{id}", [CategoryController::class, "showSubCategory"])->name("showSubCategory");
        Route::get("show-sub-child-category/{id}", [CategoryController::class, "showSubChildCategory"])->name("showSubChildCategory");
        Route::get("{id}/edit", [CategoryController::class, "edit"])->name("edit");
        Route::get("edit-sub/{id}", [CategoryController::class, "editSubCategory"])->name("editSubCategory");
        Route::get("edit-child/{id}", [CategoryController::class, "editSubChildCategory"])->name("editSubChildCategory");
        Route::put("{id}", [CategoryController::class, "update"])->name("update");
        Route::delete("{id}", [CategoryController::class, "destroy"])->name("destroy");
    });

    /* Manage Preharvest Categories */
    Route::group([
        "prefix" => "preharvest-categories",
        "as" => "preharvest-categories."
    ], function () {
        Route::get("/", [PreharvestCategoryController::class, "index"])->name("index");
        Route::get("create", [PreharvestCategoryController::class, "create"])->name("create");
        Route::get("{parent_id}/create-sub-category", [PreharvestCategoryController::class, "createSubCategory"])->name("createSubCategory");
        Route::get("{parent_id}/create-sub-child-category", [PreharvestCategoryController::class, "createSubChildCategory"])->name("createSubChildCategory");
        Route::post("/", [PreharvestCategoryController::class, "store"])->name("store");
        Route::post("updateCategoryOrder", [PreharvestCategoryController::class, "updateCategoryOrder"])->name("updateCategoryOrder");
        Route::get("show/{id}", [PreharvestCategoryController::class, "show"])->name("show");
        Route::get("show-sub-category/{id}", [PreharvestCategoryController::class, "showSubCategory"])->name("showSubCategory");
        Route::get("show-sub-child-category/{id}", [PreharvestCategoryController::class, "showSubChildCategory"])->name("showSubChildCategory");
        Route::get("{id}/edit", [PreharvestCategoryController::class, "edit"])->name("edit");
        Route::get("edit-sub/{id}", [PreharvestCategoryController::class, "editSubCategory"])->name("editSubCategory");
        Route::get("edit-child/{id}", [PreharvestCategoryController::class, "editSubChildCategory"])->name("editSubChildCategory");
        Route::put("{id}", [PreharvestCategoryController::class, "update"])->name("update");
        Route::delete("{id}", [PreharvestCategoryController::class, "destroy"])->name("destroy");
    });

    /* Manage Palm Length */
    Route::resource('palm-lengths', PalmLengthController::class);

    /* Manage Preharvest Stage */
    Route::resource('stages', PreharvestStageController::class);


    /* Manage Product Classes */
    // Breadcrumb done
    Route::resource('productClasses', ProductClassController::class);
    ///////////////////////////////////// Product Actions //////////////////////////////////////////
    // Breadcrumb done
    Route::resource('products', ProductController::class);

    Route::get('products/print-barcode/{product}', [ProductController::class, 'printBarcode'])->name('products.print-barcode');
    Route::post('products/approve/{product:id}', [ProductController::class, 'approve'])->name('products.approve');
    Route::get('/get-category-by-parent-id', [ProductController::class, 'getSubCategories'])->name('products.get_sub_categories');
    Route::post('/upload-image', [ImageController::class, 'upload_product_images'])->name('admin.upload_product_images');
    Route::get('/products/remove-image/{image_id}', [ImageController::class, 'remove_product_images'])->name('products.remove-image');
    Route::put('/toggle-status/{product}', [ProductController::class, 'acceptProduct'])->name('products.toggle-status');
    Route::put('/accept-update/{product}', [ProductController::class, 'acceptUpdate'])->name('products.accept-update');
    // ALREADY EXISTS PRODUCT -> (productTemp)
    Route::put('/refuse-update/{product}', [ProductController::class, 'refuseUpdate'])->name('products.refuse-update');
    // NEW ADDED PRODUCT WITH UPDATES -> (productNote)
    Route::put('/refuse-update2/{product}', [ProductController::class, 'refuseUpdate2'])->name('products.refuse-update2');
      // ALREADY EXISTS PRODUCT -> (productTemp)
    Route::put('/refuse-delete/{product}', [ProductController::class, 'refuseDelete'])->name('products.refuse-delete');
      //  NEW ADDED PRODUCT WITH UPDATES -> (productNote)
    Route::put('/refuse-delete2/{product}', [ProductController::class, 'refuseDelete2'])->name('products.refuse-delete2');

    Route::put('/reject/{product}', [ProductController::class, 'reject'])->name('products.reject');
    Route::post('/products/{product}/stock-update', [ProductController::class, 'updateStock'])->name('products.update-stock');
    Route::get('/products/{id}/stock-delete', [ProductController::class, 'deleteStock'])->name('products.delete-stock');

    /* Manage Countries Prices */
    Route::get('products/{id}/prices', [ProductCountryPricesController::class, 'index'])->name('products.prices.list');
    Route::post('products/{id}/prices', [ProductCountryPricesController::class, 'store'])->name('products.prices.store');
    Route::put('products/{id}/prices', [ProductCountryPricesController::class, 'update'])->name('products.prices.update');
    Route::get('products/{id}/prices/create', [ProductCountryPricesController::class, 'create'])->name('products.prices.create');
    Route::get('products/prices/edit/{id}', [ProductCountryPricesController::class, 'edit'])->name('products.prices.edit');
    Route::delete('products/prices/{id}', [ProductCountryPricesController::class, 'destroy'])->name('products.prices.delete');


    #منتجات شارفت على الإنتهاء
    Route::get('products-almostOutOfStock', [ProductController::class,'almostOutOfStock'])->name('products.almostOutOfStock');
    #منتجات نفذت من المخزون
    Route::get('products-outOfStock', [ProductController::class,'outOfStock'])->name('products.outOfStock');
    #منتجات محذوفة
    Route::get('products-deleted', [ProductController::class,'deleted'])->name('products.deleted');


    /* Manage Services */
    // Breadcrumb done
    Route::resource('services', ServiceController::class);

    Route::get('services/print-barcode/{service}', [ServiceController::class, 'printBarcode'])->name('services.print-barcode');
    Route::post('services/approve/{service:id}', [ServiceController::class, 'approve'])->name('services.approve');
    Route::get('/categories/{category}/fields', [ServiceController::class, 'getFields'])->name('services.get_fields');
    Route::post('/upload-image', [ServiceImageController::class, 'upload_service_images'])->name('admin.upload_service_images');
    Route::get('/services/remove-image/{image_id}', [ServiceImageController::class, 'remove_service_images'])->name('services.remove-image');
    Route::put('/service/toggle-status/{service}', [ServiceController::class, 'acceptService'])->name('services.toggle-status');
    Route::put('/service/accept-update/{service}', [ServiceController::class, 'acceptUpdate'])->name('services.accept-update');
    // ALREADY EXISTS PRODUCT -> (serviceTemp)
    Route::put('/service/refuse-update/{service}', [ServiceController::class, 'refuseUpdate'])->name('services.refuse-update');
    // NEW ADDED PRODUCT WITH UPDATES -> (serviceNote)
    Route::put('/service/refuse-update2/{service}', [ServiceController::class, 'refuseUpdate2'])->name('services.refuse-update2');
      // ALREADY EXISTS PRODUCT -> (serviceTemp)
    Route::put('/service/refuse-delete/{service}', [ServiceController::class, 'refuseDelete'])->name('services.refuse-delete');
      //  NEW ADDED PRODUCT WITH UPDATES -> (serviceNote)
    Route::put('/service/refuse-delete2/{service}', [ServiceController::class, 'refuseDelete2'])->name('services.refuse-delete2');

    Route::put('/service/reject/{service}', [ServiceController::class, 'reject'])->name('services.reject');

    #deleted services
    Route::get('services-deleted', [ServiceController::class,'deleted'])->name('services.deleted');
    /* Manage Countries */
    // Breadcrumb done
    //        Route::resource('countries', CountryController::class);

    /** Coupons */
    // Breadcrumb done
    Route::resource('coupons', CouponController::class);
    Route::post('coupons/status/{coupon:id}', [CouponController::class, 'changeStatus'])->name('coupons.change-status');
    Route::get('coupons/products/{query}', [CouponController::class, 'product'])->name('coupons.products');
    /* Manage Cities */
    // Breadcrumb done
    Route::resource('cities', CityController::class);

    /* Manage Areas */
    // Breadcrumb done
    Route::resource('areas', AreaController::class);

    /* certificate routes */
    // Breadcrumb done
    Route::get('certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('certificates/add/', [CertificateController::class, 'add'])->name('certificates.create');
    Route::post('certificates/store/', [CertificateController::class, 'store'])->name('certificates.store');
    Route::get('certificates/edit/{certificate:id}', [CertificateController::class, 'edit'])->name('certificates.edit');
    Route::post('certificates/update/{certificate:id}', [CertificateController::class, 'update'])->name('certificates.update');
    Route::get('certificates/delete/{certificate:id}', [CertificateController::class, 'destroy'])->name('certificates.delete');
    Route::get('certificates/requests/{certificate:id}', [CertificateController::class, 'requests'])->name('certificates.requests');
    Route::post('certificates/approve/{certificate_request:id}', [CertificateController::class, 'approve'])->name('certificates.approve');
    Route::post('certificates/reject/{certificate_request:id}', [CertificateController::class, 'reject'])->name('certificates.reject');

    /* vendor roles (permission) routes */
    // Breadcrumb done
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('roles/export', [RoleController::class, 'exportVendorsWithRoles'])->name('roles.export');
    Route::get('roles/add/', [RoleController::class, 'create'])->name('roles.create');
    Route::post('roles/store/', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/edit/{role:id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('roles/update/{role:id}', [RoleController::class, 'update'])->name('roles.update');
    Route::get('roles/delete/{role:id}', [RoleController::class, 'destroy'])->name('roles.delete');

    /* vendor users routes */
    // Breadcrumb done
    Route::get('vendor-users', [VendorUserController::class, 'index'])->name('vendor-users.index');
    Route::get('vendor-users/add/', [VendorUserController::class, 'add'])->name('vendor-users.create');
    Route::post('vendor-users/store/', [VendorUserController::class, 'store'])->name('vendor-users.store');
    Route::get('vendor-users/edit/{user:id}', [VendorUserController::class, 'edit'])->name('vendor-users.edit');
    Route::patch('vendor-users/update/{user:id}', [VendorUserController::class, 'update'])->name('vendor-users.update');
    Route::post('vendor-users/roles/{id}', [VendorUserController::class, 'getVendorRoles'])->name('vendor-users.roles');
    Route::get('vendor-users/delete/{user:id}', [VendorUserController::class, 'destroy'])->name('vendor-users.delete');
    Route::post('vendor-users/block/{user:id}', [VendorUserController::class, 'block'])->name('vendor-users.block');


    /* Manage Static Content */
    // Breadcrumb done
    Route::resource('about-us', AboutUsContentController::class);
    // Breadcrumb done
    Route::resource('privacy-policy', PrivacyPolicyContentController::class);
    // Breadcrumb done
    Route::resource('usage-agreement', UsageAgreementContentController::class);
    // Breadcrumb done
    Route::resource('qna', QnaController::class);
    // Breadcrumb done
    Route::resource('recipe', RecipeController::class);
    // Breadcrumb done
    Route::resource('blog', BlogController::class);

    Route::get('customer-cash-withdraw', [CustomerCashWithdrawRequestController::class, 'index'])
        ->name('customer-cash-withdraw.index');
    // Breadcrumb done
    Route::get('customer-cash-withdraw/{id}', [CustomerCashWithdrawRequestController::class, 'show'])
        ->name('customer-cash-withdraw.show');
    Route::put('customer-cash-withdraw/{withdrawRequest}', [CustomerCashWithdrawRequestController::class, 'update'])
        ->name('customer-cash-withdraw.update');
    // Breadcrumb done
    Route::post('productRates/update-checks', [ProductRateController::class , 'updateChecks'])->name('productRates.update-checks');
    Route::resource('productRates', ProductRateController::class);

    Route::post('serviceRates/update-checks', [ServiceRateController::class , 'updateChecks'])->name('serviceRates.update-checks');
    Route::resource('serviceRates', ServiceRateController::class);

    // Breadcrumb done
    Route::resource('product-quantities', ProductQuantityController::class);
    // Breadcrumb done
    Route::post('vendorRates/update-checks', [VendorRateController::class , 'updateChecks'])->name('vendorRates.update-checks');
    Route::resource('vendorRates', VendorRateController::class);

    Route::resource('transactionProcessRate', TransactionProcessRateController::class);
    Route::resource('orderProcessRate', OrderProcessRateController::class);


    // Breadcrumb done
    Route::resource('wareHouseRequests', VendorWarehouseRequestController::class);
    Route::get('wareHouseRequests/product/{id}', 'VendorWarehouseRequestController@showProducts')->name('wareHouseRequests.show-products');
    Route::get('wareHouseRequests/create/{id}', [VendorWarehouseRequestController::class, 'createForVendor'])->name("vendor-warehouse-request");

    // Breadcrumb done
    Route::resource('slider', SliderController::class);

    // Breadcrumb done
    Route::resource('subAdmins', SubAdminController::class);

    // Breadcrumb done
    Route::resource('rules', RuleController::class);

    // Breadcrumb done
    Route::resource('vendorWallets', VendorWalletController::class);
    Route::post('vendorWallets/import', [VendorWalletController::class , 'import'])->name('vendorWallets.import');

    Route::resource('dispensingOrder', DispensingOrderController::class);
    Route::get('initialDispensingOrder', [DispensingOrderController::class , 'initialDispensingOrder'])->name('initialDispensingOrder.index');
    Route::post('initialDispensingOrder/change', [DispensingOrderController::class , 'changeInitialDispensingOrder'])->name('initialDispensingOrder.change');
    Route::get('finalDispensingOrder', [DispensingOrderController::class , 'finalDispensingOrder'])->name('finalDispensingOrder.index');
    Route::post('finalDispensingOrder/change', [DispensingOrderController::class , 'changeFinalDispensingOrder'])->name('finalDispensingOrder.change');
    // Breadcrumb done
    Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update-all');
    Route::get('settings/aramex_settings', [SettingController::class, 'aramex_settings'])->name('settings.aramex.index');
    Route::post('settings/aramex_settings_update', [SettingController::class, 'aramex_settings_update'])->name('settings.aramex.update');
    Route::resource('settings', SettingController::class)->only(['index', 'edit', 'update']);
    Route::resource('line_shipping_price', LineShippingPriceController::class);


    // Breadcrumb done
    Route::get('warehouses/pending', [WarehouseController::class, 'pending'])->name('warehouses.pending');
    Route::post('warehouses/accepting/{id}', [WarehouseController::class, 'accepting'])->name('warehouses.accepting');
    Route::post('warehouses/reject/{id}', [WarehouseController::class, 'reject'])->name('warehouses.reject');
    Route::get('warehouses/updated', [WarehouseController::class, 'updated'])->name('warehouses.updated');
    Route::post('warehouses/acceptUpdate/{id}', [WarehouseController::class, 'acceptUpdate'])->name('warehouses.acceptUpdate');
    Route::post('warehouses/refuseUpdate/{id}', [WarehouseController::class, 'refuseUpdate'])->name('warehouses.refuseUpdate');


    Route::resource('warehouses', WarehouseController::class);


    Route::get("warehouses/export/excel", [WarehouseController::class, "excel"])->name('warehouses.export');

    // Breadcrumb done
    Route::resource('domestic-zones', DomesticZoneController::class);
    Route::get('domestic-zones-delivery-fees/download-demo', [DomesticZoneDeliveryFeesController::class, 'downloadDeliveryFeesDemo'])
        ->name('domestic-zones-delivery-fees.download-demo');
    Route::post('domestic-zones-delivery-fees/{domestic}/upload-sheet', [DomesticZoneDeliveryFeesController::class, 'uploadSheet'])
        ->name('domestic-zones-delivery-fees.upload-sheet');

    // Breadcrumb done
    Route::resource('torodCompanies', TorodCompanyController::class);
    // Breadcrumb done
    Route::resource('banks', BankController::class);
    // Shipping Method done
    Route::resource('shipping-methods', ShippingMethodController::class);
    Route::post('shipping-methods/{shippingMethod}/sync-zones', [ShippingMethodController::class, 'syncZones'])->name('shipping-methods.sync-zones');

    Route::prefix("reports/vendors-orders")
        ->controller(VendorReportController::class)
        ->group(function () {
            Route::get("/", "vendorsOrders")->name("reports.vendors-orders");
            Route::get("/excel", "vendorsOrdersExcel")->name("reports.vendors-orders.excel");
            Route::get("/print", "vendorsOrdersPrint")->name("reports.vendors-orders.print");
        });

    Route::prefix("reports/total-vendors-orders")
        ->controller(\App\Http\Controllers\Admin\VendorTotalsReportController::class)
        ->group(function () {
            Route::get("/", "totalVendorsOrders")->name("reports.total-vendors-orders");
            Route::get("/excel", "totalVendorsOrdersExcel")->name("reports.total-vendors-orders.excel");
            Route::get("/print", "totalVendorsOrdersPrint")->name("reports.total-vendors-orders.print");
        });

    Route::prefix("vendors-agreements")
        ->controller(VendorAgreementController::class)
        ->group(function () {
            Route::get("/", "index")->name("vendors-agreements.index");
            Route::get("/send", "sendForm")->name("vendors-agreements.send-form");
            Route::post("/send", "send")->name("vendors-agreements.send");
            Route::put("/cancel/{agreement}", "cancel")->name("vendors-agreements.cancel");
            Route::put("/resend/{agreement}", "resend")->name("vendors-agreements.resend");
        });

    Route::resource('client-messages', ClientMessageController::class)->only(['index', 'edit', 'update']);
    // post-harvest-services route
    Route::resource('post-harvest-services-departments',PostHarvestServicesController::class);
    // get fields
    Route::group(['prefix' => 'post-harvest-services-departments'],function(){
        Route::get('{id}/fields',[PostHarvestServicesController::class,'fields'])->name('post-harvest-services-departments.fields');
        // post-harvest-services-department-fields
        Route::get('{id}/fields/create',[PostHarvestServicesDepartmentFieldController::class,'create'])->name('post-harvest-services-departments.fields.create');
        // post-harvest-services-department-fields store
        Route::post('fields/store',[PostHarvestServicesDepartmentFieldController::class,'store'])->name('post-harvest-services-departments.fields.store');
        // post-harvest-services-department-fields edit
        Route::get('{id}/fields/edit',[PostHarvestServicesDepartmentFieldController::class,'edit'])->name('post-harvest-services-departments.fields.edit');
        // post-harvest-services-department-fields update
        Route::put('{id}/fields/update',[PostHarvestServicesDepartmentFieldController::class,'update'])->name('post-harvest-services-departments.fields.update');
        // post-harvest-services-department-fields destroy
        Route::delete('{id}/fields/destroy',[PostHarvestServicesDepartmentFieldController::class,'destroy'])->name('post-harvest-services-departments.fields.destroy');
    });
    Route::post('client-sms/sendsms', [ClientSMSController::class, 'sendsms'])->name("client-sms.sendsms");
    Route::resource('client-sms', ClientSMSController::class);

    Route::resource('page-seo', PageSeoController::class);

    Route::prefix("tax-invoices")
        ->controller(TaxInvoiceController::class)
        ->group(function () {
            Route::get("/{transaction}/print", "printTaxInvoice")->name("tax-invoices.print");
            // Able to download tax invoices for sub-orders
            Route::get("/order/{order}/print", "printOrderTaxInvoice")->name("order-tax-invoices.print");
        });

    Route::prefix("international-tax-invoices")
        ->controller(InternationalTaxInvoiceController::class)
        ->group(function () {
            Route::get("/{transaction}/print", "printTaxInvoice")->name("international-tax-invoices.print");
        });

    Route::prefix("service-tax-invoices")
    ->controller(ServiceTaxInvoiceController::class)
    ->group(function () {
        Route::get("/{transaction}/print", "printTaxInvoice")->name("service-tax-invoices.print");
        // Able to download tax invoices for sub-orders
        Route::get("/order/{order}/print", "printOrderTaxInvoice")->name("service-order-tax-invoices.print");
    });

    Route::prefix("international-service-tax-invoices")
        ->controller(InternationalTaxInvoiceController::class)
        ->group(function () {
            Route::get("/{transaction}/print", "printTaxInvoice")->name("service-international-tax-invoices.print");
        });

    /*check aramex configurations*/
    Route::get('aramex', [\App\Http\Controllers\Admin\AramexController::class, 'shipping']);
    Route::get('aramexTest', [\App\Http\Controllers\Admin\AramexController::class, 'aramexTest'])->name('aramexTrackShipments');
    /*check Tabby configurations*/


    //Reports
    Route::name('reports.')->prefix('reports')->group(function () {
        Route::get('/products-quantity', [ReportController::class, 'products_quantity'])->name('products_quantity');
        Route::get('/products-most-selling', [ReportController::class, 'mostSellingProducts'])->name('mostSellingProducts');
        Route::get('/vendors_earnings', [ReportController::class, 'vendors_earnings'])->name('vendors_earnings');
        Route::get('/vendors_sales', [ReportController::class, 'vendors_sales'])->name('vendors_sales');
        Route::get('/PaymentMethods', [ReportController::class, 'PaymentMethods'])->name('PaymentMethods');
        Route::get('/SatisfactionClientsWallet', [ReportController::class, 'SatisfactionClientsWallet'])->name('SatisfactionClientsWallet');
        Route::get('/OrdersShipping', [ReportController::class, 'OrdersShipping'])->name('OrdersShipping');
        Route::get('/ShippingCharges', [ReportController::class, 'ShippingCharges'])->name('ShippingCharges');
        Route::get('/ShippingChargesCompleted', [ReportController::class, 'ShippingChargesCompleted'])->name('ShippingChargesCompleted');
        Route::get('/ShippingChargesWait', [ReportController::class, 'ShippingChargesWait'])->name('ShippingChargesWait');
        Route::get('/SalesAllVendors', [ReportController::class, 'SalesAllVendors'])->name('SalesAllVendors');
        Route::get('/SalesAllVendorsPrint/{id?}', [ReportController::class, 'SalesAllVendorsPrint'])->name('SalesAllVendors.print');
        Route::get('/vendors_sales_print', [ReportController::class, 'vendors_sales_print'])->name('vendors_sales_print');


        // Route::get('/vendorsSales', [ReportController::class, 'vendorsSales'])->name('vendorsSales');
        // Route::get('/vendorsSales/print/{id}', [ReportController::class, 'vendorsSales_print'])->name('vendorsSales_print');
        // Route::get('/vendorsSales/OrderReceive', [ReportController::class, 'vendorsSales_OrderReceive'])->name('vendorsSales.OrderReceive');
        // Route::get('/vendorsSales/facture', [ReportController::class, 'vendorsSales_facture'])->name('vendorsSales.facture');

        // Route::get('/logisticsPartner', [ReportController::class, 'logisticsPartner'])->name('logisticsPartner');
        // Route::get('/MarketingPartner', [ReportController::class, 'MarketingPartner'])->name('MarketingPartner');
        // Route::get('/platformSales', [ReportController::class, 'platformSales'])->name('platformSales');

        // Route::get('/vendorOrdersSells', [ReportController::class, 'vendorOrdersSells'])->name('vendorOrdersSells');




        Route::get('/TaxinvoiceCommission', [ReportController::class, 'TaxinvoiceCommission'])->name('TaxinvoiceCommission');

        Route::get('/DipositFromEanat', [ReportController::class, 'DipositFromEanat'])->name('DipositFromEanat');

        Route::get('/vendorOrdersSellsCompleted', [ReportController::class, 'vendorOrdersSellsCompleted'])->name('vendorOrdersSellsCompleted');
        Route::get('/vendorOrdersSellsWait', [ReportController::class, 'vendorOrdersSellsWait'])->name('vendorOrdersSellsWait');

        // Route::get('export', [ReportController::class, 'exportExcel'] )->name('export_excel');
      });

    //Invoice Routes
    Route::resource("invoices", \App\Http\Controllers\Admin\InvoiceController::class)
        ->except(["update", "destroy", "edit"]);

    Route::get("invoices/export-pdf/{invoice}", [\App\Http\Controllers\Admin\InvoiceController::class, "printTaxInvoice"])
        ->name("invoices.export-pdf");
});
