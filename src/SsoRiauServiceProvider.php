<?php
namespace OjiSatriani\SsoRiau;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class SsoRiauServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfigurations();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ssoriau', function (Application $app) {
            $config = $app['config']->get('ssoriau', []);
            $ssoriau = new SsoRiau($config);
            return $ssoriau;
        });
        $this->app->register('OjiSatriani\SsoRiau\SsoRiauServiceProvider');
    }

    public function provides()
    {
        return ['ssoriau'];
    }

    /**
     * Register the package configurations.
     *
     * @return void
     */
    protected function registerConfigurations()
    {
        $this->mergeConfigFrom($this->packagePath('config/config.php'), 'ssoriau');
        $this->publishes([
            $this->packagePath('config/config.php') => config_path('ssoriau.php')
        ], 'config');
    }

    /**
     * Loads a path relative to the package base directory.
     *
     * @param  string  $path
     * @return string
     */
    protected function packagePath($path = '')
    {
        return sprintf('%s/../%s', __DIR__, $path);
    }
}