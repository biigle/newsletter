<?php

namespace Biigle\Modules\Newsletter;

use Biigle\Services\Modules;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class NewsletterServiceProvider extends ServiceProvider
{

   /**
   * Bootstrap the application events.
   *
   * @param Modules $modules
   * @param  Router  $router
   * @return  void
   */
    public function boot(Modules $modules, Router $router)
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'newsletter');

        $router->group([
            'namespace' => 'Biigle\Modules\Newsletter\Http\Controllers',
            'middleware' => 'web',
        ], function ($router) {
            require __DIR__.'/Http/routes.php';
        });

        $modules->register('newsletter', [
            'viewMixins' => [
                // 'dashboardMain',
            ],
            'controllerMixins' => [
                //
            ],
            'apidoc' => [
               //__DIR__.'/Http/Controllers/Api/',
            ],
        ]);

        $this->publishes([
            __DIR__.'/public/assets' => public_path('vendor/newsletter'),
        ], 'public');
    }

    /**
    * Register the service provider.
    *
    * @return  void
    */
    public function register()
    {
        //
    }
}
