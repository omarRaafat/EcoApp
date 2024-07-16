<?php

use App\Http\Controllers\LanguageController;
use App\Integrations\Shipping\Shipment;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\Wallet\UpdateWalletBalanceEportal;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


Route::get('/clear', function () {
    $exitCode = Artisan::call('optimize:clear');
    echo "<br/> done optimize clear";
    $exitCode = Artisan::call('cache:clear');
    echo "<br/> done cache clear";
    $exitCode = Artisan::call('config:clear');
    echo "<br/> done config clear";
    $exitCode = Artisan::call('route:clear');
    echo "<br/> done route clear";
    $exitCode = Artisan::call('view:clear');
    echo "<br/> done view clear";
    echo "<br/> <h1>done All clear</h1>";
});

Route::get('/{view}','HomeController@index');
Route::get('/languages/{locale}', [LanguageController::class, 'setLang'])->name('set.locale');

Route::get('/oauth/redirect', [\App\Http\Controllers\EportalAuthController::class, 'redirect']);
Route::get('/oauth/callback', [\App\Http\Controllers\EportalAuthController::class, 'callback']);

// route::get('test',function(){
//     dd(__('admin.vendors-agreements-keys.vendor-sign') ,__('admin.vendors-agreements-keys.approve-date'));
// });
