<?php

namespace MatiosFree\LRbac\Tests;

use Illuminate\Foundation\Application;
use MatiosFree\App\Authorization;
use MatiosFree\LRbac\RbacServiceProvider;


abstract class TestCase extends \Orchestra\Testbench\TestCase {

    /**
     * Setup the test environment.
     */
    public function setUp(): void {
        parent::setUp();
        app()['config']->set('rbac.handler', Authorization::class);
    }


    /**
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            RbacServiceProvider::class,
        ];
    }

}