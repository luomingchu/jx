<?php namespace Smt\Alipay;

use Illuminate\Support\ServiceProvider;

class AlipayServiceProvider extends ServiceProvider {

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
		$this->package('smt/alipay');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$me = $this;
		$this->app->bindShared('alipay', function($app) use ($me)
		{
			$alipay = new Alipay($app, $app['view']);

			$alipay->setLogger($app['log'])->setQueue($app['queue']);

			// Here we will determine if the mailer should be in "pretend" mode for this
			// environment, which will simply write out e-mail to the logs instead of
			// sending it over the web, which is useful for local dev environments.
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
		return array();
	}

}
