<?php

namespace NumberToWord\NumberToWords\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use NumberToWord\NumberToWords\NumberToWordsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'NumberToWord\\NumberToWords\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            NumberToWordsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_numbertowords_table.php.stub';
        $migration->up();
        */
    }
}
