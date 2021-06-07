<?php

namespace Tas\Master;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MasterServiceProvider extends ServiceProvider
{

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'Tas\\Master\\Controllers';

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
        $menuService = $this->app->make("routing");

        $menuService->addMenu([
            "path" => "/master",
            "class" => "",
            "name" => "Master",
            "priority" => 1,
            "children" => [
                [
                    "path" => "/master/foo",
                    "name" => "Foo",
                    "class" => "nav-icon fas fa-copy",
                    "component" => "assets/master/js/foo"
                ],
                [
                    "path" => "/master/bar",
                    "name" => "Bar",
                    "class" => "far fa-circle nav-icon",
                    "component" => "assets/master/js/bar"
                ]
            ]
        ]);

        $this->loadDefault();
    }

    private function loadDefault()
    {
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadViewsFrom(__DIR__ . '/views', 'master');
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'master');

        Route::middleware("web")
            ->namespace($this->namespace)
            ->group(__DIR__ . '/routes/web.php');

        $assetLocalDirJs = __DIR__ . "/assets/js";
        Route::middleware("web")
            ->prefix("assets/master/js")
            ->group(function () use ($assetLocalDirJs) {
                Route::get("/{dir}/{file}", function ($dir, $file) use ($assetLocalDirJs) {
                    $file_path = $assetLocalDirJs . "/" . $dir . "/" . $file;
                    if (is_file($file_path))
                        return response()
                            ->download(
                                $file_path,
                                "file_name",
                                [
                                    'Content-Type' => "text/javascript"
                                ]
                            );
                    return abort(404);
                });

                Route::get("/{file}", function ($file) use ($assetLocalDirJs) {
                    $file_path = $assetLocalDirJs . "/" . $file;
                    if (is_file($file_path))
                        return response()
                            ->download(
                                $file_path,
                                null,
                                [
                                    'Content-Type' => "text/javascript"
                                ]
                            );
                    return abort(404);
                });
            });
    }
}
