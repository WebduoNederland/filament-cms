<?php

namespace WebduoNederland\FilamentCms\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use WebduoNederland\FilamentCms\FilamentCmsServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            FilamentCmsServiceProvider::class,
        ];
    }
}
