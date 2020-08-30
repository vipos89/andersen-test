<?php

namespace App\Providers;

use App\Services\TransactionService;
use App\Services\UserService;
use App\Services\WalletService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WalletService::class, static function($app){
            return new WalletService();
        });
        $this->app->singleton(UserService::class, static function($app){
            return new UserService();
        });
        $this->app->singleton(TransactionService::class, static function($app){
            return new TransactionService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
