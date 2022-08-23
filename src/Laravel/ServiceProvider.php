<?php
namespace OjiSatriani\SsoRiau\Laravel;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use OjiSatriani\SsoRiau\SsoClientLibrary;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'ssoriau');
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('ssoriau.php')
            ], 'config');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SsoClientLibrary::class, function (Application $app) {
            $config = $app['config']->get('ssoriau', []);
            return new SsoClientLibrary($config);
        });
    }

    public function provides()
    {
        return [SsoClientLibrary::class];
    }
}