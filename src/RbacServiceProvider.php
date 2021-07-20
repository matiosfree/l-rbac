<?php
namespace MatiosFree\LRbac;

use Illuminate\Support\ServiceProvider;

/**
 * Based on native Laravel's abilities
 */
class RbacServiceProvider extends ServiceProvider {

    /**
     * This will be used to register config & view in
     * package namespace.
     */
    protected string $packageName = 'rbac';

    public function boot(): void {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/rbac.php' => config_path($this->packageName . '.php')
            ], 'config');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->mergeConfigFrom(__DIR__.'/../config/rbac.php', $this->packageName);

        \Gate::before(function ($user, $ability, $arguments) {
            $class = config($this->packageName.'.handler');
            $rbac = new $class();
            return $rbac->checkAccess($user, $ability, $arguments);
        });
    }

}