<?php

namespace App\Providers;

use App\Interfaces\RepositoryInterfaces\TransactionInterface;
use App\Interfaces\RepositoryInterfaces\WalletInterface;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            WalletInterface::class,
            WalletRepository::class
        );
        $this->app->bind(
            TransactionInterface::class,
            TransactionRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
