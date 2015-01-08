<?php namespace Smt\Sms;

use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider {

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
		$this->package('smt/sms');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$me = $this;

		$this->app->bindShared('smser', function($app) use ($me)
		{
			$smser = new Smser($app, $app['view']);

			$smser->setLogger($app['log'])->setQueue($app['queue']);

			// Here we will determine if the mailer should be in "pretend" mode for this
			// environment, which will simply write out e-mail to the logs instead of
			// sending it over the web, which is useful for local dev environments.
			$pretend = $app['config']->get('Sms::pretend', false);

			$smser->pretend($pretend);

			return $smser;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('smser');
	}

}
