<?php namespace Smt\Alipaywap;

use Illuminate\Support\ServiceProvider;

class AlipaywapServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    public function boot()
    {
        $this->package('smt/alipaywap');
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $me = $this;
        $this->app->bindShared('alipaywap', function($app) use ($me)
        {
            $alipay = new Alipaywap(str_replace(['zbond_', 'zblstest_'], '', \Config::get('database.connections.own.database')), []);

            return $alipay;
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('alipaywap');
	}

}
