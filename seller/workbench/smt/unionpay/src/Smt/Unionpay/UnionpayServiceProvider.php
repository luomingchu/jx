<?php

namespace Smt\Unionpay;

use Illuminate\Support\ServiceProvider;

class UnionpayServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('smt/unionpay');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $me = $this;

        $this->app->bindShared('unionpay', function ($app) use($me)
        {
            $unionpay = new Unionpay($app, $app['view']);

            return $unionpay;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'unionpay'
        );
    }
}
