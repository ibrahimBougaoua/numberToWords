<?php

namespace NumberToWord\NumberToWords;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use NumberToWord\NumberToWords\Commands\NumberToWordsCommand;

class NumberToWordsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('numbertowords')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_numbertowords_table')
            ->hasCommand(NumberToWordsCommand::class);
    }
}
