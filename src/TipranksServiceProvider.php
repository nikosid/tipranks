<?php

namespace Nikosid\Tipranks;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TipranksServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('tipranks')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->bind(Tipranks::class, function ($app) {
            $email = config('services.tipranks.email');
            $password = config('services.tipranks.password');

            if (! $email || ! $password) {
                throw new \RuntimeException('Tipranks email and password must be set in the configuration.');
            }

            return new Tipranks($email, $password);
        });
    }
}
