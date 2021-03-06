<?php

namespace Happy\ThreadMan;

use Happy\ThreadMan\Channel;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ThreadMan::class, function ($app) {
            return new ThreadMan($app);
        });
    }
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**Share channel in everywhere view layout */
        \View::composer('*', function($view){

            $channels = \Cache::rememberForever('channels', function(){
                return Channel::all();
            });

            // $channels = Channel::all();
            $view->with('channels', $channels);
        });

        /**Run console build db */
        if ($this->app->runningInConsole()) {
            $this->registerMigrations();
        }
    }

    /**
     * Register User's migration files.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        return;
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ThreadMan::class];
    }
}