<?php namespace BigElephant\Routing;

use Illuminate\Routing\RoutingServiceProvider as BaseServiceProvider;

class RoutingServiceProvider extends BaseServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['router'] = $this->app->share(function($app)
		{
			return new Router($app);
		});

		$this->registerUrlGenerator();

		$this->registerRedirector();
	}
}