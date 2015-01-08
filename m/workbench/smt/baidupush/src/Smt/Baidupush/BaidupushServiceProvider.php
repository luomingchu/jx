<?php namespace Smt\Baidupush;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class BaidupushServiceProvider extends ServiceProvider {

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
		$this->package('smt/baidupush');
        $this->app['bdpush'] = $this->app->share(function ($app) {
            $baidupush = new Baidupush('zb_circle', $app);
            return $baidupush;
        });
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
        return array('bdpush');
	}

}
