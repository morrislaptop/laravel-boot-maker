<?php

namespace Morrislaptop\LaravelBootMaker;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Morrislaptop\LaravelBootMaker\Commands\LaravelBootMakerCommand;

class LaravelBootMakerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-boot-maker')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-boot-maker_table')
            ->hasCommand(LaravelBootMakerCommand::class);
    }
}
