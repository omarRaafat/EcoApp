<?php

namespace App\Providers;

use App\HttpFactory;
use App\Enums\CustomHeaders;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
        }
        app()->bind(\Illuminate\Http\Client\Factory::class, HttpFactory::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(request()->wantsJson() && request()->segment(1)!='vendor' && request()->segment(1)!='admin')
        {
            app()->setLocale(request()->header(CustomHeaders::LANG));
        }
        Paginator::useBootstrapFive();
        Schema::defaultStringLength(191);

        if(App::isProduction()) {
            URL::forceScheme('https');
        }
    }
}
