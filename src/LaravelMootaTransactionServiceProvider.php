<?php

namespace Codewithdiki\LaravelMootaTransaction;

use Illuminate\Support\ServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Codewithdiki\LaravelMootaTransaction\Contracts\LaravelMootaTransaction;

class LaravelMootaTransactionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-moota-transaction')
            ->hasRoutes(['web'])
            ->hasConfigFile()
            ->hasViews();
    }

    public function register()
    {
        parent::register();

        $this->app->bind('laravel-moota-transaction', function () {
            return new LaravelMootaTransaction;
        });
    }
}
