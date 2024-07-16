<?php

use App\Http\Controllers\Api\ServiceCartController;
use App\Http\Controllers\Webhooks\AramexShipmentWebhook;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QnaController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\GuestController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\BlogPostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HelpdeskController;
use App\Http\Controllers\Api\CashWithdrawController;
use App\Http\Controllers\Api\StaticContentController;
use App\Http\Controllers\Api\FavoriteProductController;
use App\Http\Controllers\Api\PageSeoController;
use App\Http\Controllers\Api\ShippingMethodController;
use App\Http\Controllers\Webhooks\TorodWebhookController;
use App\Http\Controllers\Webhooks\UpdateBezzShipmentWebhook;
use App\Http\Controllers\Webhooks\UpdateBezzWarehouseQnttWebhook;
use App\Http\Controllers\Webhooks\SplShipmentWebhook;
use App\Http\Controllers\Api\Eportal\AuthController;
use App\Http\Controllers\Api\Eportal\UserWalletController;
use App\Http\Controllers\Api\Eportal\SsoController;
use App\Http\Controllers\Api\FavoriteServiceController;
use App\Http\Controllers\Api\ServiceCategoryController;
use App\Http\Controllers\Api\ServiceController;
use App\Models\Transaction;
use App\Services\Api\FavoriteServiceService;

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


require_once "apiRoutes/transaction.php";




// Route::get('test', function(){
//     $order = Order::latest()->first();
//     $response = Connection::depositWallet($order->wallet_id, 100 , $order->id , config('app.eportal_url') . 'deposit-to-wallet' , 'w' , 1)->json();
//     dd($response);

// });



Route::group([
    'middleware' => 'api','prefix' => 'auth'
], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('generate-code', 'AuthController@generateCode');
    Route::post('register', 'AuthController@register');
    Route::post('update-profile', 'AuthController@updateProfile');
    Route::get('profile', 'AuthController@profile');
    Route::post('logout', 'AuthController@logout');
    Route::post('update-language/{lang}', 'AuthController@updateLanguage');

});

Route::post('/WalletSecretKey',[UserWalletController::class,'WalletSecretKey']);


Route::group(['middleware' => 'api','prefix' => 'wallet'],function () {
    Route::get('total', 'WalletController@totalAmount');
    Route::get('total-withdraw', 'WalletController@totalWithdraw');
    Route::get('transactions', 'WalletController@getTransactions');
    Route::get('data', 'WalletController@walletData');
});



/*Route::group(['middleware' => ['api', 'is_banned'],'prefix' => 'address'],function () {
    Route::get('', 'AddressController@currentUserAddresses');
    Route::get('/show/{id}', 'AddressController@show');
    Route::post('update', 'AddressController@update');
    Route::post('store', 'AddressController@store');
    Route::post('delete/{id}', 'AddressController@delete');
    Route::post('set-default/{id}', 'AddressController@setDefault');
    Route::get('/geo-data', 'AddressController@GeoData');
});*/

Route::group(['prefix' => 'products'],function () {
    Route::get("", [ProductController::class, "index"]);
    Route::get("/site-map", [ProductController::class, "site_map"]);
    Route::get("/category/{id}", [ProductController::class, "CategotyProducts"]);
    Route::get("/{id}", [ProductController::class, "show"]);
    Route::get("/product-related/{id}", [ProductController::class, "product_related"]);
});

Route::group(['prefix' => 'services'],function () {
    Route::get("/", [ServiceController::class, "index"]);
    Route::get("/site-map", [ServiceController::class, "site_map"]);
    Route::get("/category/{id}", [ServiceController::class, "CategoryServices"]);
    Route::get("/{id}", [ServiceController::class, "show"]);
    Route::get("/service-related/{id}", [ServiceController::class, "service_related"]);
});

Route::group(['middleware' => 'api','prefix' => 'qnas'],function () {
    Route::get("", [QnaController::class, "index"]);
    Route::get("/{id}", [QnaController::class, "show"]);
});

Route::group(['middleware' => 'api','prefix' => 'vendors'],function () {
    Route::get("", [VendorController::class, "index"]);
    Route::get("/products/{id}", [VendorController::class, "sortedProducts"]);
    Route::get("/services/{id}", [VendorController::class, "sortedServices"]);
    Route::get("/site-map", [VendorController::class, "site_map"]);
    Route::get("/{id}", [VendorController::class, "show"]);
});

Route::group(['middleware' => 'api','prefix' => 'help-desk'],function () {
    Route::post("contact_us", [HelpdeskController::class, "contact_us"]);
    Route::get("contact_us/info", [SettingController::class, "contactInfo"]);
});

Route::group(['middleware' => 'api','prefix' => 'search'],function () {
    Route::get("", [SearchController::class, "globalSearch"]);
});

Route::group(['middleware' => 'api','prefix' => 'recipe'],function () {
    Route::get("",      [RecipeController::class, "index"]);
    Route::get("/{id}", [RecipeController::class, "show"]);
});

Route::group(['middleware' => 'api','prefix' => 'blog'],function () {
    Route::get("", [BlogPostController::class, "index"]);
    Route::get("/homePage", [BlogPostController::class, "homePage"]);
    Route::get("/post/{id}", [BlogPostController::class, "show"]);
});

Route::group(['middleware' => 'api','prefix' => 'static'],function () {
    Route::get("/{type}", [StaticContentController::class, "index"]);
});

Route::group(['middleware' => 'api','prefix' => 'country'],function () {
    Route::get("/all", [CountryController::class, "index"]);
    Route::post("delivery_to", [CountryController::class, "deliveryTo"]);
});
Route::get('/warehousesCities',[CountryController::class,'warehousesCities']);

Route::get('/servicesCities',[CountryController::class,'servicesCities']);

Route::group(['middleware' => 'api','prefix' => 'setting'],function () {
    Route::get("/home-page-slider", [SettingController::class, "homePageSlider"]);
    Route::get("/website-settings", [SettingController::class, "websiteSetting"]);
    Route::get("/main-data", [SettingController::class, "mainData"]);
});

// cm
Route::group(['middleware' => 'api','prefix' => 'cash-withdraw-request'],function () {
    Route::post("/", [CashWithdrawController::class, "store"]);
});

//Route::group(['middleware' => 'api','prefix' => 'shipping'],function () {
Route::group(['prefix' => 'shipping'],function () {
    Route::Post("/methods", [ShippingMethodController::class, "getAvailableMethods"]);
});

Route::group(['middleware' => 'api','prefix' => 'webhooks'],function () {
    Route::post('torod', [TorodWebhookController::class, "updateStatus"]);
    Route::post('beez/update-shipment-status', [UpdateBezzShipmentWebhook::class, "updateStatus"]);
    Route::post('beez/update-warehouse-qnt', [UpdateBezzWarehouseQnttWebhook::class, "updateStatus"]);
    Route::post('spl/shipment-status', [SplShipmentWebhook::class, "shipmentStatus"]);
    Route::post('aramex/shipment-status', [AramexShipmentWebhook::class , "shipmentStatus"]);
});

Route::prefix('guest')
    ->as('guest.')
    ->controller(GuestController::class)
    ->group(function() {
        Route::post('token', 'generateToken')->name('get-token');
        Route::post('refresh-token', 'refreshToken')->name('refresh-token');
        Route::post('cart/edit', 'editCart')->name('cart.edit');
        Route::post('cart/delete', 'deleteCart')->name('cart.delete');
        Route::get('cart/products', 'cartProducts')->name('cart.products');
    });
Route::get("banks", [BankController::class, "index"]);
Route::get("seo/{page}", [PageSeoController::class, "getPageSeo"]);


Route::group(['prefix' => 'eportal'], function () {
    Route::post("login", [AuthController::class, "checkIdentity"]);
    Route::post("otp", [AuthController::class, "checkOTP"]);
    Route::post("resendkOTP", [AuthController::class, "resendkOTP"]);
    Route::post("register", [AuthController::class, "register"]);
    Route::post("getClientByToken", [AuthController::class, "getClientByToken"]);

});

/* @mention Will added Authorization routes SSO here */
Route::group(['middleware' => 'verifyClientAuth'] , function(){
    Route::group(['prefix' => 'eportal'], function () {
        route::get('profile' , [AuthController::class, "profile"]);
        Route::post("logout", [AuthController::class, "logout"]);
        Route::get("wallets", [UserWalletController::class, "getMyWallets"]);
        Route::post("authorizationWallet", [AuthController::class, "authorizationWallet"]);
    });

    Route::group(['prefix' => 'cart'], function () {
        Route::group(['middleware' => 'verifyAuthorizationWallet'],function () {
            Route::post('delete/{id}', 'AddressController@delete');
            Route::post('summary', 'CartController@summary');
        });
        Route::post('checkout', 'TransactionController@checkout')->name('cart.checkout'); //->middleware("throttle:10,10");
        Route::get('pay-callback', 'TransactionController@pay_callback')->name('paymant-callback');
    });

    Route::group(['prefix' => 'address'],function () {
        Route::get('', 'AddressController@currentUserAddresses');
        Route::get('/show/{id}', 'AddressController@show');
        Route::post('update', 'AddressController@update');
        Route::post('store', 'AddressController@store');
        Route::post('set-default/{id}', 'AddressController@setDefault');
        Route::get('/geo-data', 'AddressController@GeoData');
    });

    Route::group(['prefix' => 'favorite'],function () {
        Route::get("/", [FavoriteProductController::class, "getFavorite"]);
        Route::post("/add", [FavoriteProductController::class, "addFavorite"]);
        Route::post("/delete/{id}", [FavoriteProductController::class, "deleteFavorite"]);
    });

    Route::group(['prefix' => 'service-favorite'],function () {
        Route::get("/", [FavoriteServiceController::class, "getFavorite"]);
        Route::post("/add", [FavoriteServiceController::class, "addFavorite"]);
        Route::post("/delete/{id}", [FavoriteServiceController::class, "deleteFavorite"]);
    });

    Route::group(['middleware' => ['is_banned'],'prefix' => 'order'],function () {
        Route::get('my-orders', 'TransactionController@userOrders');
        Route::get('track-my-orders', 'TransactionController@trackUserOrders');
        Route::get('order-deatails/{transaction_id}', 'TransactionController@orderDetails');
        Route::get('order-services-details/{transaction_id}', 'TransactionController@orderServicesDetails');
        Route::get('order-rate/{transaction_id}', 'TransactionController@getOrderDetailsForRate');
        Route::get('order-service-rate/{transaction_id}', 'TransactionController@getOrderServiceDetailsForRate');
        Route::post('save-order-rate/{transaction_id}', 'TransactionController@saveOrderRate');
        Route::post('reorder/{transaction_id}', 'CartController@reorder');
        Route::post('reorder/services/{transaction_id}', 'CartController@reorderServices');
        Route::post('cancel', 'TransactionController@cancelOrder');

        Route::post('success-feedback', 'TransactionController@successOrderFeedback');
        Route::post('vendor-feedback', 'TransactionController@OrderVendorFeedback');
        Route::post("/products/add-review", [ProductController::class, "addReview"]);
        Route::post("service/add-review", [ServiceController::class, "serviceAddReview"]);
    });

}); // end group middleware verifyClientAuth

Route::group(['prefix' => 'cart', 'middleware' => ['ClientOrGuestAuth']], function () {
    // update product quantity only
    Route::post('edit', 'CartController@addOrEditProduct');
    //get all cart products
    Route::get('products', 'CartController@getVendorProducts')->name('products');
    //delete product from cart
    Route::post('delete', 'CartController@deleteProduct');
    //cart
    Route::post('update-address', 'CartController@updateAddress');
    Route::post('update-vendor-shippingType', 'CartController@updateVendorShippingType');
    Route::post('update-vendor-warehouse', 'CartController@updateVendorWarehouse');
});

// add services in cart
Route::group(['prefix' => 'cart/services','middleware' => ['ClientOrGuestAuth']],function(){
    // add service in cart
    Route::post('add','CartController@addServicesToCart');
    // get services from cart
    Route::get('get', 'CartController@getServicesInCart');
    //delete service from cart
    Route::delete('delete/{id}', 'CartController@deleteService');
    // update address
    Route::post('update-address', 'CartController@updateServicesAddress');
    //service checkout
    Route::post('checkout', 'TransactionController@serviceCheckout');
});
Route::group(['prefix' => 'categories'],function () {
    Route::get("/", [CategoryController::class, "index"]);
    Route::get("home", [CategoryController::class, "homePageCategory"]);
    Route::get("/site-map", [CategoryController::class, "site_map"]);
    Route::get("get_tree/{id}", [CategoryController::class, "getCategoryTreeAll"]);
    Route::get("parent/{id}", [CategoryController::class, "parent"]);
    Route::get("show/{id}", [CategoryController::class, "show"]);
    Route::get("products/{id}", [CategoryController::class, "getCategoryProductsAll"]);
});

Route::group(['prefix' => 'service-categories'],function () {
    Route::get("/", [ServiceCategoryController::class, "index"]);
    Route::get("home", [ServiceCategoryController::class, "homePageCategory"]);
    Route::get("/site-map", [ServiceCategoryController::class, "site_map"]);
    Route::get("show/{id}", [ServiceCategoryController::class, "show"]);
    Route::get("services/{id}", [ServiceCategoryController::class, "getCategoryServicesAll"]);
});

Route::get('/tabby',[\App\Http\Controllers\Api\PaymentController::class,'checkout']);
Route::post('/aramex',[\App\Http\Controllers\Api\AramexController::class,'shipping']);
Route::post('/calculateRate',[\App\Http\Controllers\Api\AramexController::class,'calculateRate']);

Route::post('/oauth2/createUser',[AuthController::class,'createUser']);
Route::post('/oauth2/UpdateUser',[AuthController::class,'UpdateUser']);
Route::post('/oauth2/RemoveUser',[AuthController::class,'RemoveUser']);

//Test push inti staging
