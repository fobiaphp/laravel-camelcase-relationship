<?php

namespace Fobia\Relationship\Tests;

use Orchestra\Testbench\TestCase;
// use Mockery as m;
// use PHPUnit\Framework\TestCase;


class CamelCaseBuilderTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('services.github', [
            'client_id' => 'github-client-id',
            'client_secret' => 'github-client-secret',
            'redirect' => 'http://your-callback-url',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [];
    }

    public function test_camel_case()
    {
        $this->assertTrue(true);
    }


}
