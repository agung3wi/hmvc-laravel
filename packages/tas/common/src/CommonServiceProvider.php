<?php

namespace Tas\Common;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Tas\Common\Service\Routing;

class CommonServiceProvider extends ServiceProvider
{

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'Tas\\Common\\Controllers';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadDefault();
        $this->app->singleton('routing', function () {
            return new Routing();
        });
    }

    private function loadDefault()
    {
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadViewsFrom(__DIR__ . '/views', 'common');
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'common');

        Route::middleware("web")
            ->namespace($this->namespace)
            ->group(__DIR__ . '/routes/web.php');
    }
}
